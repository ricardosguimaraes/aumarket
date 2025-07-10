<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait TitleWithBreadcrumbsStyleControls
{
    use Control;

    protected function addTitleWithBreadcrumbsStyleSection(): void
    {
        $this->startStyleControlsSection('title_with_breadcrumbs');

        $this->add_control(
            'full_width',
            [
                'label' => esc_html__('Full width', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'breadcrumbs_separator_color',
            [
                'label' => esc_html__('Separator', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs-v2__separator path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'title_heading',
            [
                'label' => esc_html__('Title', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-title-with-breadcrumbs__title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'title_accent_color',
            [
                'label' => esc_html__('Accent color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-title-with-breadcrumbs__title span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'background_heading',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-title-with-breadcrumbs__container:before' => 'background-color: {{VALUE}};'
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
                    '{{WRAPPER}} .listivo-title-with-breadcrumbs__container:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->endControlsSection();
    }

    /**
     * @return bool
     */
    public function isFullWidth(): bool
    {
        return !empty((int)$this->get_settings_for_display('full_width'));
    }

}