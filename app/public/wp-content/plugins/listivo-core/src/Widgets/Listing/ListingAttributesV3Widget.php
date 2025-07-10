<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ListingAttributesControl;

class ListingAttributesV3Widget extends BaseModelSingleWidget
{
    use ListingAttributesControl;

    public function getKey(): string
    {
        return 'listing_attributes_v3';
    }

    public function getName(): string
    {
        return esc_html__('Ad attributes V3', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addFieldsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addStyleControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addStyleControls(): void
    {

        $this->add_control(
            'first_attribute_heading',
            [
                'label' => esc_html__('First attribute', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'first_attribute_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attribute-v3:first-child' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-listing-attribute-v3:first-child path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'first_attribute_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attribute-v3:first-child' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'first_attribute_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attribute-v3:first-child' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'first_attribute_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-attribute-v3:first-child',
            ]
        );

        $this->add_control(
            'attribute_heading',
            [
                'label' => esc_html__('Attribute', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'attribute_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attribute-v3' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-listing-attribute-v3 path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'attribute_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attribute-v3' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'attribute_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-attribute-v3' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'attribute_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-attribute-v3',
            ]
        );
    }

}