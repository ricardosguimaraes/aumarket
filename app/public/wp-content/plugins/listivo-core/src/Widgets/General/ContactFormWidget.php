<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\General\BaseContactFormWidget;

class ContactFormWidget extends BaseContactFormWidget
{
    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addContactFormControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addLabelColorControl();

        $this->addBackgroundColorControl();

        $this->addFieldBackgroundControl();

        $this->addFieldBorderColorControl();

        $this->addButtonControls();

        $this->endControlsSection();
    }

    private function addLabelColorControl(): void
    {
        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Label color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-form__label' => 'color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addBackgroundColorControl(): void
    {
        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-form' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addFieldBackgroundControl(): void
    {
        $this->add_control(
            'input_bg',
            [
                'label' => esc_html__('Field background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-input-v2' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-input-v2 input' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-contact-form__text textarea' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addFieldBorderColorControl(): void
    {
        $this->add_control(
            'input_border',
            [
                'label' => esc_html__('Field border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-input-v2' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-input-v2 input' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-contact-form__text' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-contact-form__text textarea' => 'border-color: {{VALUE}};',
                ]
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
                    '{{WRAPPER}} .listivo-button__text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-button__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-button' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }
}