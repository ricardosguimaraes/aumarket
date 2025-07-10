<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;

class UserHeroWidget extends BaseUserWidget
{
    public function getKey(): string
    {
        return 'user_hero';
    }

    public function getName(): string
    {
        return esc_html__('User Hero', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->addContentSection();

        $this->startStyleControlsSection();

        $this->addDecorationControl();

        $this->addFullWidthControl();

        $this->addBackgroundImageControl();

        $this->addBackgroundHeightControl();

        $this->addMaskControls();

        $this->addUserStyleControls();

        $this->addAddressIconControls();

        $this->addTextStyleControls();

        $this->addSocialIconStyleControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addContentSection(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'hide_address',
            [
                'label' => esc_html__('Hide Address', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'hide_member_since',
            [
                'label' => esc_html__('Hide Member Since', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'hide_social',
            [
                'label' => esc_html__('Hide Social', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->endControlsSection();
    }

    public function showAddress(): bool
    {
        return empty((int)$this->get_settings_for_display('hide_address'));
    }

    public function showMemberSince(): bool
    {
        return empty((int)$this->get_settings_for_display('hide_member_since'));
    }

    public function showSocial(): bool
    {
        return empty((int)$this->get_settings_for_display('hide_social'));
    }

    public function decorationEnabled(): bool
    {
        return !empty((int)$this->get_settings_for_display('decoration'));
    }

    private function addDecorationControl(): void
    {
        $this->add_control(
            'decoration',
            [
                'label' => esc_html__('Decoration', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    private function addAddressIconControls(): void
    {
        $this->add_control(
            'icon_label',
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
                    '{{WRAPPER}} .listivo-small-icon path' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-small-icon' => 'background: {{VALUE}};',
                ]
            ]
        );
    }

    private function addBackgroundImageControl(): void
    {
        $this->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    public function getBackgroundImage(): string
    {
        $image = $this->get_settings_for_display('background_image');

        return $image['url'] ?? '';
    }

    private function addMaskControls(): void
    {
        $this->add_control(
            'mask_heading',
            [
                'label' => esc_html__('Mask', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'mask_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-hero__background:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mask_opacity',
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
                    '{{WRAPPER}} .listivo-user-hero__background:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
    }

    private function addFullWidthControl(): void
    {
        $this->add_control(
            'full_width',
            [
                'label' => esc_html__('Full width', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function isFullWidth(): bool
    {
        return !empty((int)$this->get_settings_for_display('full_width'));
    }

    private function addBackgroundHeightControl(): void
    {
        $this->add_responsive_control(
            'background_height',
            [
                'label' => esc_html__('Background height (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-hero__background' => 'height: {{VALUE}}px;',
                    '{{WRAPPER}} .listivo-user-hero__background:before' => 'height: {{VALUE}}px;',
                    '{{WRAPPER}} .listivo-user-hero__background img' => 'height: {{VALUE}}px;',
                    '{{WRAPPER}} .listivo-user-hero__content' => 'margin-top: calc({{VALUE}}px - 110px);',
                ]
            ]
        );
    }

    private function addUserStyleControls(): void
    {
        $this->add_control(
            'user_heading',
            [
                'label' => esc_html__('User', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'user_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-hero__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'user_typography',
                'selector' => '{{WRAPPER}} .listivo-user-hero__name',
            ]
        );
    }

    private function addSocialIconStyleControls(): void
    {
        $this->add_control(
            'social_icon_heading',
            [
                'label' => esc_html__('Social icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'social_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-social-icon svg path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'social_icon_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-social-icon:hover svg path' => 'fill: {{VALUE}};',
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

        $this->add_control(
            'social_icon_hover_border_color',
            [
                'label' => esc_html__('Hover border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon:hover' => 'border-color: {{VALUE}};',
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
                    '{{WRAPPER}} .listivo-user-hero__data' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .listivo-user-hero__data',
            ]
        );
    }
}