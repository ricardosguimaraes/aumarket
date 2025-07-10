<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;

class MailchimpNewsletterFormV2Widget extends MailchimpNewsletterFormWidget
{
    use SimpleLabelControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'mailchimp_newsletter_form_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Mailchimp Newsletter Form V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->addBackgroundImageControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addTextStyleControls();

        $this->addFormBorderRadiusControl();

        $this->addButtonControls();

        $this->endControlsSection();
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

    /**
     * @return string
     */
    public function getBackgroundImage(): string
    {
        $image = $this->get_settings_for_display('background_image');

        return $image['url'] ?? '';
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
                    '{{WRAPPER}} .listivo-newsletter-v2__heading' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'text_accent_color',
            [
                'label' => esc_html__('Accent color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-v2__heading span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .listivo-newsletter-v2__heading',
            ]
        );
    }

    private function addButtonControls(): void
    {
        $this->add_control(
            'button_heading',
            [
                'label' => esc_html__('Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form__button path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form__button' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'button_width',
            [
                'label' => esc_html__('Width (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form__button' => 'width: {{VALUE}}px;'
                ],
            ]
        );

        $this->add_control(
            'button_height',
            [
                'label' => esc_html__('Height (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form__button' => 'height: {{VALUE}}px;'
                ],
            ]
        );
    }

    private function addFormBorderRadiusControl(): void
    {
        $this->add_control(
            'form_border_radius',
            [
                'label' => esc_html__('Form border radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
    }

}