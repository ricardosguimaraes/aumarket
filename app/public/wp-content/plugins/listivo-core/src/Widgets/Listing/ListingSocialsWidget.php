<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SocialShareControls;

class ListingSocialsWidget extends BaseModelSingleWidget
{
    use SocialShareControls;

    public function getKey(): string
    {
        return 'listing_socials';
    }

    public function getName(): string
    {
        return esc_html__('Ad Icons', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addShowPrintControl();

        $this->addSocialShareControls();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addBackgroundControl();

        $this->addBorderColorControl();

        $this->addIconStyleControls();

        $this->addMarginControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addBackgroundControl(): void
    {
        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-socials' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addBorderColorControl(): void
    {
        $this->add_control(
            'border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-socials' => 'border-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addIconStyleControls(): void
    {
        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('icon_style_tabs');

        $this->start_controls_tab(
            'icon_style_tab_normal',
            [
                'label' => esc_html__('Normal', 'listivo-core')
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-social-icon i' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_border_color',
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
            'icon_style_tab_hover',
            [
                'label' => esc_html__('Hover', 'listivo-core')
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon:hover path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-social-icon:hover i' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_border_hover_color',
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

    private function addShowPrintControl(): void
    {
        $this->add_control(
            'show_print',
            [
                'label' => esc_html__('Display Print', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showPrint(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_print'));
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'socials_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-socials' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }
}