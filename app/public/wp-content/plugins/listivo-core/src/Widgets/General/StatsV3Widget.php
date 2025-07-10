<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class StatsV3Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'stats_v3';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Stats V3', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addAttributesControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addAlignControl();

        $this->addValueStyleControls();

        $this->addAfterValueStyleControls();

        $this->addLabelStyleControls();

        $this->endControlsSection();
    }

    private function addAttributesControl(): void
    {
        $attributes = new Repeater();

        $attributes->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $attributes->add_control(
            'after_value',
            [
                'label' => esc_html__('After Value', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $attributes->add_control(
            'label',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'attributes',
            [
                'label' => esc_html__('Attributes', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $attributes->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getAttributes(): Collection
    {
        $attributes = $this->get_settings_for_display('attributes');
        if (empty($attributes) || !is_array($attributes)) {
            return tdf_collect();
        }

        return tdf_collect($attributes)
            ->map(static function ($attribute) {
                if (empty($attribute['value']) || empty($attribute['label'])) {
                    return false;
                }

                return $attribute;
            })
            ->filter(static function ($attribute) {
                return $attribute !== false;
            });
    }

    private function addValueStyleControls(): void
    {
        $this->add_control(
            'value_heading',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'value_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-stats-v3__value' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'value_typography',
                'selector' => '{{WRAPPER}} .listivo-stats-v3__value',
            ]
        );
    }

    private function addAfterValueStyleControls(): void
    {
        $this->add_control(
            'after_value_heading',
            [
                'label' => esc_html__('After value', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'after_value_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-stats-v3__after-value' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'after_value_typography',
                'selector' => '{{WRAPPER}} .listivo-stats-v3__after-value',
            ]
        );
    }

    private function addLabelStyleControls(): void
    {
        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-stats-v3__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .listivo-stats-v3__label',
            ]
        );
    }

    private function addAlignControl(): void
    {
        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Alignment', 'listivo-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'listivo-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'listivo-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'listivo-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
            ]
        );
    }

    /**
     * @return string
     */
    public function getAlign(): string
    {
        $align = $this->get_settings_for_display('align');
        if (empty($align)) {
            return 'left';
        }

        return (string)$align;
    }


    /**
     * @return string
     */
    public function getTabletAlign(): string
    {
        $align = $this->get_settings_for_display('align_tablet');
        if (empty($align)) {
            return 'left';
        }

        return (string)$align;
    }

    /**
     * @return string
     */
    public function getMobileAlign(): string
    {
        $align = $this->get_settings_for_display('align_mobile');
        if (empty($align)) {
            return 'left';
        }

        return (string)$align;
    }

    /**
     * @return string
     */
    public function getAlignClasses(): string
    {
        return implode(' ', [
            'listivo-stats-v3--mobile-align-' . $this->getMobileAlign(),
            'listivo-stats-v3--tablet-align-' . $this->getTabletAlign(),
            'listivo-stats-v3--align-' . $this->getAlign(),
        ]);
    }

}