<?php

namespace Tangibledesign\Listivo\Widgets\General\Search;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait ViewSelectorStyleSection
{
    use Control;

    protected function addViewSelectorStyleSection(): void
    {
        $this->startStyleControlsSection('view_selector_style', esc_html__('View selector', 'listivo-core'));

        $this->add_control(
            'view_selector_heading',
            [
                'label' => esc_html__('View selector', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'view_selector_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-view-selector:not(.listivo-view-selector--active) path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'view_selector_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-view-selector:not(.listivo-view-selector--active):hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'view_selector_active_color',
            [
                'label' => esc_html__('Active color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-view-selector.listivo-view-selector--active path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-view-selector.listivo-view-selector--active:hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'view_selector_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-view-selector:not(.listivo-view-selector--active)' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'view_selector_hover_background',
            [
                'label' => esc_html__('Hover background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-view-selector:not(.listivo-view-selector--active):hover' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'view_selector_active_background',
            [
                'label' => esc_html__('Active background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-view-selector.listivo-view-selector--active' => 'background: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-view-selector.listivo-view-selector--active:hover' => 'background: {{VALUE}}; border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'view_selector_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-view-selector:not(.listivo-view-selector--active)' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'view_selector_hover_border_color',
            [
                'label' => esc_html__('Hover border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-view-selector:not(.listivo-view-selector--active):hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

}