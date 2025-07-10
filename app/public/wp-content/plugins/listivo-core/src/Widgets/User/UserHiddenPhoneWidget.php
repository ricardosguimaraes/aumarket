<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ContactButtonStyleControls;

class UserHiddenPhoneWidget extends \Tangibledesign\Framework\Widgets\User\UserHiddenPhoneWidget implements ModelSingleWidget
{
    use HasModel;
    use ContactButtonStyleControls;

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addShowAtStartControl();

        $this->addContactButtonStyleControls();

        $this->addStarColor();

        $this->addEyeStyleControls();

        $this->addMarginControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'phone_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    private function addStarColor(): void
    {
        $this->add_control(
            'star_color',
            [
                'label' => esc_html__('Star color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__inner span' => 'color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addEyeStyleControls(): void
    {
        $this->add_control(
            'eye_icon_heading',
            [
                'label' => esc_html__('Eye icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'eye_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__icon--additional path' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'eye_icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__icon--additional' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'eye_icon_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__icon--additional' => 'border-color: {{VALUE}}',
                ]
            ]
        );
    }
}