<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait BreadcrumbsStyleSection
{
    use Control;

    protected function addBreadcrumbsStyleSection(): void
    {
        $this->startStyleControlsSection('breadcrumbs_style', esc_html__('Breadcrumbs', 'listivo-core'));

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs-v2' => 'height: {{VALUE}}px;',
                ]
            ]
        );


        $this->add_control(
            'item_separator_color',
            [
                'label' => esc_html__('Separator color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs-v2__separator path' => 'fill: {{VALUE}};'
                ]
            ]
        );


        $this->add_control(
            'item_heading',
            [
                'label' => esc_html__('Item', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'item_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs-v2__item' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'item_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs-v2__item:not(.listivo-breadcrumbs-v2__item:last-child):hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'item_active_heading',
            [
                'label' => esc_html__('Current item', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'item_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs-v2__item:last-child' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'item_active_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs-v2__item:last-child:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->addBackgroundStyleControls();

        $this->endControlsSection();
    }

    private function addBackgroundStyleControls(): void
    {
        $this->add_control(
            'background_heading',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'has_background',
            [
                'label' => esc_html__('Enabled', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs-v2:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'background_opacity',
            [
                'label' => esc_html__('Opacity', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs-v2:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
    }

    /**
     * @return bool
     */
    public function hasBackground(): bool
    {
        return !empty((int)$this->get_settings_for_display('has_background'));
    }

}