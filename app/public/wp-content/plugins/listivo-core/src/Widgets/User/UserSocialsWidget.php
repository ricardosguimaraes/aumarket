<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\PostSingleWidget;

class UserSocialsWidget extends BaseUserWidget implements ModelSingleWidget, PostSingleWidget
{

    public function getKey(): string
    {
        return 'user_socials';
    }

    public function getName(): string
    {
        return esc_html__('User Socials', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->start_controls_tabs('social_icons_style_tabs');

        $this->start_controls_tab(
            'social_icons_style_tab_normal',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'social_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon i' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'social_icon_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'social_icons_style_tab_hover',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'social_icon_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon:hover i' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'social_icon_hover_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon:hover' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

}