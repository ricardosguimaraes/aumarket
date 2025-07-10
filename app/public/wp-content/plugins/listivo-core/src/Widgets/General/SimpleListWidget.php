<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class SimpleListWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'simple_list';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Simple list', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addItemsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addGapControl();

        $this->addAlignControl();

        $this->addIconStyleControls();

        $this->addTextStyleControls();

        $this->endControlsSection();
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        $items = $this->get_settings_for_display('items');
        if (empty($items) || !is_array($items)) {
            return tdf_collect();
        }

        return tdf_collect($items)->map(static function ($item) {
            return $item['item'];
        });
    }

    private function addItemsControl(): void
    {
        $items = new Repeater();

        $items->add_control(
            'item',
            [
                'label' => esc_html__('Item', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => esc_html__('Items', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $items->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    private function addGapControl(): void
    {
        $this->add_responsive_control(
            'gap',
            [
                'label' => esc_html__('Gap', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-simple-list' => 'gap: {{VALUE}};'
                ]
            ]
        );
    }

    private function addTextStyleControls(): void
    {
        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-simple-list__text' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .listivo-simple-list__text',
            ]
        );
    }

    private function addIconStyleControls(): void
    {
        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-simple-list__icon path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-simple-list__icon' => 'background: {{VALUE}};'
                ]
            ]
        );
    }

    private function addAlignControl(): void
    {
        $this->add_responsive_control(
            'align',
            [
                'label' => esc_html__('Align', 'listivo-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'listivo-core'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'listivo-core'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'listivo-core'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-simple-list' => 'align-items: {{VALUE}};'
                ]
            ]
        );
    }

}