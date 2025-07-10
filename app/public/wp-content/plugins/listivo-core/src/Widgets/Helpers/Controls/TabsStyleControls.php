<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait TabsStyleControls
{
    use Control;

    protected function addTabsStyleSection(): void
    {
        $this->startStyleControlsSection('lst_tabs_style', esc_html__('Tabs', 'listivo-core'));

        $this->add_control(
            'tab_style_heading',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );


        $this->add_control(
            'tab_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-tab-v2:not(.listivo-tab-v2--active)' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'tab_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-tab-v2:not(.listivo-tab-v2--active)' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'tab_hover_border',
            [
                'label' => esc_html__('Hover border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-tab-v2:not(.listivo-tab-v2--active):hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tab_style_active_heading',
            [
                'label' => esc_html__('Active', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'active_tab_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-tab-v2--active' => 'color: {{VALUE}} !important;',
                ]
            ]
        );

        $this->add_control(
            'active_tab_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-tab-v2--active' => 'background: {{VALUE}} !important;',
                ]
            ]
        );

        $this->endControlsSection();
    }

}