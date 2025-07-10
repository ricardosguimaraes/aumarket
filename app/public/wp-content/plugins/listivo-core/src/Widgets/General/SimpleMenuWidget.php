<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\General\BaseSimpleMenuWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextAlignControl;

class SimpleMenuWidget extends BaseSimpleMenuWidget
{
    use TextAlignControl;

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addMenuControl();

        $this->addTextAlignControl('li');

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addSpaceBetweenLinksControl();

        $this->addLinkColorControl();

        $this->addLinkHoverColorControl();

        $this->addCircleHoverColorControl();

        $this->endControlsSection();
    }

    private function addLinkColorControl(): void
    {
        $this->add_control(
            'color',
            [
                'label' => tdf_admin_string('color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} a' => 'color: {{VALUE}} !important;'
                ]
            ]
        );
    }

    private function addLinkHoverColorControl(): void
    {
        $this->add_control(
            'color_hover',
            [
                'label' => tdf_admin_string('color_hover'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item a:hover' => 'color: {{VALUE}} !important',
                ]
            ]
        );
    }

    private function addCircleHoverColorControl(): void
    {
        $this->add_control(
            'circle_color',
            [
                'label' => esc_html__('Circle color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .menu-item a:before' => 'background-color: {{VALUE}};'
                ]
            ]
        );
    }

    private function addSpaceBetweenLinksControl(): void
    {
        $this->add_responsive_control(
            'space_between_links',
            [
                'label' => esc_html__('Space between links', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-vertical-link-list .menu-item:not(:first-child) a' => 'margin-top: {{SIZE}}{{UNIT}} !important',
                ]
            ]
        );
    }
}