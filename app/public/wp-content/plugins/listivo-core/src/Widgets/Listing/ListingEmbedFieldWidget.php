<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\EmbedFieldControl;

class ListingEmbedFieldWidget extends BaseModelSingleWidget
{
    use EmbedFieldControl;

    public function getKey(): string
    {
        return 'listing_embed_field';
    }

    public function getName(): string
    {
        return esc_html__('Ad Embed Field', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addEmbedFieldControl();

        $this->addForceRatioControl();

        $this->addLabelControls();

        $this->addMarginControl();

        $this->addPaddingControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-section__label',
            ]
        );

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'embed_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    private function addPaddingControl(): void
    {
        $this->add_responsive_control(
            'embed_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    public function getEmbedCode(): string
    {
        $listing = $this->getModel();
        $embedField = $this->getEmbedField();

        if (!$listing || !$embedField) {
            return '';
        }

        return $embedField->getEmbedCode($listing);
    }

    protected function addLabelControls(): void
    {
        $this->add_control(
            'show_label',
            [
                'label' => tdf_admin_string('show_label'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'label',
            [
                'label' => tdf_admin_string('label'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('video'),
                'condition' => [
                    'show_label' => '1',
                ]
            ]
        );
    }

    public function showLabel(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_label'));
    }

    public function getLabel(): string
    {
        $label = (string)$this->get_settings_for_display('label');

        if (empty($label)) {
            return tdf_string('video');
        }

        return $label;
    }

    private function addForceRatioControl(): void
    {
        $this->add_control(
            'disable_ratio',
            [
                'label' => esc_html__('Do not maintain aspect ratio', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ],
        );
    }

    public function forceRation(): bool
    {
        return empty((int)$this->get_settings_for_display('disable_ratio'));
    }
}