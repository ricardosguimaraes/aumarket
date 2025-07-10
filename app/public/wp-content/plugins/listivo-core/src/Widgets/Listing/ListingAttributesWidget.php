<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\BackgroundColorControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\BorderColorControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\BorderRadiusControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextColorControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TypographyControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ListingAttributesControl;

class ListingAttributesWidget extends BaseModelSingleWidget
{
    use TypographyControl;
    use TextColorControl;
    use BackgroundColorControl;
    use BorderRadiusControl;
    use BorderColorControl;
    use SimpleLabelControl;
    use ListingAttributesControl;

    public function getKey(): string
    {
        return 'listing_attributes';
    }

    public function getName(): string
    {
        return esc_html__('Ad Attributes', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->addContentControls();

        $this->addStyleControls();
    }

    private function addContentControls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->add_responsive_control(
            'tags_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attributes' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_responsive_control(
            'tags_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attributes' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->addFieldsControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addStyleControls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextColorControl('.listivo-tag');

        $this->addBackgroundColorControl('.listivo-tag');

        $this->addTypographyControl('.listivo-tag');

        $this->addBorderColorControl('.listivo-tag');

        $this->addBorderRadiusControl('.listivo-tag');

        $this->add_responsive_control(
            'attribute_margin',
            [
                'label' => esc_html__('Space Between (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-tags' => 'gap: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_responsive_control(
            'attribute_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-tag' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-tag__icon svg' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-tag__icon svg path' => 'fill: {{VALUE}} !important;',
                    '{{WRAPPER}} .listivo-tag__icon i' => 'color: {{VALUE}} !important;',
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_max_width',
            [
                'label' => esc_html__('Icon Max Width', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-tag__icon' => 'max-width: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'icon_margin',
            [
                'label' => esc_html__('Icon Space', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-tag__icon' => 'margin-right: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->endControlsSection();
    }
}