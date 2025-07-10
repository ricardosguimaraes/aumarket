<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class MailchimpNewsletterFormV3Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'mailchimp_newsletter_form_v3';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Mailchimp Newsletter Form V3', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'form_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_border_color',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'input_heading',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'input_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form .listivo-input-v2' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-newsletter-form .listivo-input-v2 input' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form .listivo-input-v2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-newsletter-form .listivo-input-v2:placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-newsletter-form .listivo-input-v2 input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-newsletter-form .listivo-input-v2 input:placeholder' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'input_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form .listivo-input-v2' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .listivo-newsletter-form .listivo-input-v2 input' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'input_icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'input_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-input-v2__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'input_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    "{{WRAPPER}} .listivo-input-v2__icon" => 'background: {{VALUE}};',
                ]
            ]
        );

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
            'button_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-newsletter-form__button' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

}