<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait ShareIconsStyleSection
{
    use Control;

    protected function addSocialShareIconsControls(): void
    {
        $this->start_controls_tabs('social_share_icons_style_tabs');

        $this->start_controls_tab(
            'social_share_icons_style_tab_normal',
            [
                'label' => esc_html__('Normal', 'listivo-core')
            ]
        );

        $this->add_control(
            'share_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-social-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-social-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'share_border_color',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'social_share_icons_style_tab_hover',
            [
                'label' => esc_html__('Hover', 'listivo-core')
            ]
        );

        $this->add_control(
            'share_icon_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-social-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-social-icon:hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'share_border_hover_color',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
    }

    protected function addSocialShareIconsStyleSection(): void
    {
        $this->startStyleControlsSection('social_share_icons_style', esc_html__('Share icons', 'listivo-core'));

        $this->addSocialShareIconsControls();

        $this->endControlsSection();
    }
}