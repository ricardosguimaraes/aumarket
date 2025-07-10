<?php

namespace Tangibledesign\Listivo\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Typography;

class ButtonsTab extends Tab_Base
{
    /**
     * @return string
     */
    public function get_id(): string
    {
        return 'listivo-buttons';
    }

    /**
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('Listivo Buttons', 'listivo-core');
    }

    /**
     * @return string
     */
    public function get_group(): string
    {
        return 'theme-style';
    }

    /**
     * @return string
     */
    public function get_icon(): string
    {
        return 'eicon-button';
    }

    protected function register_tab_controls(): void
    {
        $this->start_controls_section(
            'listivo_buttons',
            [
                'label' => esc_html__('Listivo Buttons', 'listivo-core'),
                'tab' => $this->get_id(),
            ]
        );

        $this->generateButtonControls(
            'regular_button',
            esc_html__('Regular', 'listivo-core'),
            '.listivo-button--regular'
        );

        $this->generateButtonControls(
            'primary_1',
            esc_html__('Primary 1', 'listivo-core'),
            '.listivo-button--primary-1'
        );

        $this->generateButtonControls(
            'primary_2',
            esc_html__('Primary 2', 'listivo-core'),
            '.listivo-button--primary-2'
        );

        $this->end_controls_tabs();

        $this->end_controls_section();
    }

    /**
     * @param string $key
     * @param string $label
     * @param string $selector
     */
    private function generateButtonControls(string $key, string $label, string $selector): void
    {
        $this->add_control(
            'heading_' . $key,
            [
                'label' => $label,
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => $key . '_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $selector . ' .listivo-button__text',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name' => $key . '_text_shadow',
                'selector' => $selector . ' .listivo-button__text',
            ]
        );

        $this->add_responsive_control(
            $key . '_height',
            [
                'label' => esc_html__('Height', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    $selector => 'height: {{SIZE}}{{UNIT}};',
                    $selector . ' .listivo-button__icon' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}}; border-bottom-width: {{SIZE}}{{UNIT}};',
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
            ]
        );

        $this->start_controls_tabs($key . '_tabs');

        $this->start_controls_tab(
            $key . '_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            $key . '_background',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $selector => 'background-color: {{VALUE}};',
                    $selector . ' .listivo-button__icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            $key . '_text_color',
            [
                'label' => esc_html__('Text Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $selector => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            $key . '_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $selector . ' .listivo-button__icon' => 'color: {{VALUE}};',
                    $selector . ' .listivo-button__icon i' => 'color: {{VALUE}};',
                    $selector . ' .listivo-button__icon svg' => 'fill: {{VALUE}};',
                    $selector . ' .listivo-button__icon svg path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            $key . '_icon_background',
            [
                'label' => esc_html__('Icon Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $selector . ' .listivo-button__icon' => 'border-bottom-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $key . '_shadow',
                'selector' => 'a' . $selector . ', ' . $selector,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => $key . '_border',
                'selector' => $selector,
                'fields_options' => [
                    'color' => [
                        'dynamic' => [],
                    ],
                ],
            ]
        );

        $this->add_control(
            $key . '_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            $key . '_hover_tab',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            $key . '_hover_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $selector . ':hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            $key . '_hover_text_color',
            [
                'label' => esc_html__('Text Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $selector . ':hover .listivo-button__text' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            $key . '_hover_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $selector . ':hover .listivo-button__icon' => 'color: {{VALUE}};',
                    $selector . ':hover .listivo-button__icon i' => 'color: {{VALUE}};',
                    $selector . ':hover .listivo-button__icon svg' => 'fill: {{VALUE}};',
                    $selector . ':hover .listivo-button__icon svg path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            $key . '_hover_icon_background',
            [
                'label' => esc_html__('Icon Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $selector . ':hover .listivo-button__icon' => 'border-bottom-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => $key . '_hover_shadow',
                'selector' => $selector . ':hover',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => $key . '_hover_border',
                'selector' => $selector . ':hover',
                'fields_options' => [
                    'color' => [
                        'dynamic' => [],
                    ],
                ],
            ]
        );

        $this->add_control(
            $key . '_hover_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

}