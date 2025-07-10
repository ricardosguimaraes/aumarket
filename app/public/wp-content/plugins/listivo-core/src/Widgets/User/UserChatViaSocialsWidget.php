<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;

class UserChatViaSocialsWidget extends BaseUserWidget implements ModelSingleWidget
{
    use HasModel;

    public function getKey(): string
    {
        return 'user_chat_via_socials';
    }

    public function getName(): string
    {
        return esc_html__('Chat via Socials', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addGlobalInitialMessage();

        $this->addIconsControls();

        $this->endControlsSection();

        $this->addVisibilitySection();

        $this->addGeneralStyleSection();
    }

    private function addGeneralStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'button_heading',
            [
                'label' => esc_html__('Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );


        $this->add_responsive_control(
            'button_width',
            [
                'label' => esc_html__('Width', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'px'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-chat-via-socials__button' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_space_between_icon_and_text',
            [
                'label' => esc_html__('Space between icon and text', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-chat-via-socials__icon' => 'margin-right: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-chat-via-socials__button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-chat-via-socials__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-chat-via-socials__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('button_style_tabs');

        $this->start_controls_tab(
            'button_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => esc_html__('Text Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-chat-via-socials__button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-chat-via-socials__button svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-chat-via-socials__button svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-chat-via-socials__button i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-chat-via-socials__button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'button_text_color_hover',
            [
                'label' => esc_html__('Text Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-chat-via-socials__button:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-chat-via-socials__button:hover svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-chat-via-socials__button:hover svg path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-chat-via-socials__button:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_background_color_hover',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-chat-via-socials__button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->endControlsSection();
    }

    private function addGlobalInitialMessage(): void
    {
        $this->add_control(
            'global_initial_message',
            [
                'label' => esc_html__('Global initial message', 'listivo-core'),
                'description' => esc_html__('Setting from wp-admin -> Listivo Panel -> User Panel -> Custom Initial Message', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function useGlobalInitialMessage(): bool
    {
        return !empty((int)$this->get_settings_for_display('global_initial_message'));
    }

    /**
     * @param Model|false $model
     * @return string
     */
    public function getInitialMessage($model): string
    {
        if (!$model || !is_singular(tdf_model_post_type())) {
            return '';
        }

        if (!$this->useGlobalInitialMessage()) {
            return tdf_string('i_m_interested_in') . ' ' . $model->getName();
        }

        return tdf_settings()->getMessageSystemInitialMessage($model);
    }

    private function addIconsControls(): void
    {
        $this->add_control(
            'whatsapp_custom_icon',
            [
                'label' => esc_html__('WhatsApp Custom Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'viber_custom_icon',
            [
                'label' => esc_html__('Viber Custom Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );
    }

    public function isWhatsAppIconSet(): bool
    {
        $whatsappIcon = $this->get_settings_for_display('whatsapp_custom_icon');
        return !empty($whatsappIcon['value']);
    }

    public function isWhatsAppSvgIcon(): bool
    {
        $whatsappIcon = $this->get_settings_for_display('whatsapp_custom_icon');
        return $whatsappIcon['library'] === 'svg';
    }

    public function getWhatsAppIcon(): string
    {
        $whatsappIcon = $this->get_settings_for_display('whatsapp_custom_icon');
        return $whatsappIcon['value'];
    }

    public function getWhatsAppSvgIcon(): string
    {
        $whatsappIcon = $this->get_settings_for_display('whatsapp_custom_icon');
        return $whatsappIcon['value']['url'];
    }

    public function isViberIconSet(): bool
    {
        $viberIcon = $this->get_settings_for_display('viber_custom_icon');
        return !empty($viberIcon['value']);
    }

    public function isViberSvgIcon(): bool
    {
        $viberIcon = $this->get_settings_for_display('viber_custom_icon');
        return $viberIcon['library'] === 'svg';
    }

    public function getViberIcon(): string
    {
        $viberIcon = $this->get_settings_for_display('viber_custom_icon');
        return $viberIcon['value'];
    }

    public function getViberSvgIcon(): string
    {
        $viberIcon = $this->get_settings_for_display('viber_custom_icon');
        return $viberIcon['value']['url'];
    }
}