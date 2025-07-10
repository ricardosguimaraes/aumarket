<?php

namespace Tangibledesign\Listivo\Widgets\Listing;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;

class ListingUserWidget extends BaseModelSingleWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_user';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Owner', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addPaddingControl();

        $this->addUserStyleControls();

        $this->addAddressStyleControls();

        $this->addAddressIconControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addPaddingControl(): void
    {
        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    private function addAddressIconControls(): void
    {
        $this->add_control(
            'address_icon_label',
            [
                'label' => esc_html__('Location icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'address_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-small-icon path' => 'fill: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'address_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-small-icon' => 'background: {{VALUE}};',
                ]
            ]
        );
    }

    private function addUserStyleControls(): void
    {
        $this->add_control(
            'user_heading',
            [
                'label' => esc_html__('User', 'listivo-core'),
                'type' => Controls_Manager::HEADING,

            ]
        );

        $this->add_control(
            'user_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-user__name',
            ]
        );
    }


    private function addAddressStyleControls(): void
    {
        $this->add_control(
            'address_heading',
            [
                'label' => esc_html__('Address', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'address_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user__address' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'address_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-user__address',
            ]
        );
    }

}