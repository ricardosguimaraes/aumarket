<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class StatsV2Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'stats_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Stats V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addAttributesControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addValueColorControl();

        $this->addSeparatorColorControl();

        $this->addLabelColorControl();

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
            'label',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
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

        return tdf_collect($attributes);
    }

    private function addValueColorControl(): void
    {
        $this->add_control(
            'value_color',
            [
                'label' => esc_html__('Value color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-stats-v2__value' => 'color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addLabelColorControl(): void
    {
        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Label color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-stats-v2__label' => 'color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addSeparatorColorControl(): void
    {
        $this->add_control(
            'separator_color',
            [
                'label' => esc_html__('Separator', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-stats-v2__label:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

}