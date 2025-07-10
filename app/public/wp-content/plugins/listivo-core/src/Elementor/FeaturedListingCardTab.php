<?php

namespace Tangibledesign\Listivo\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Group_Control_Typography;

class FeaturedListingCardTab extends Tab_Base
{

    public function get_id(): string
    {
        return 'listivo-featured-listing-card';
    }

    public function get_title(): string
    {
        return esc_html__('Featured Ad Card', 'listivo-core');
    }

    public function get_group(): string
    {
        return 'theme-style';
    }

    public function get_icon(): string
    {
        return 'fas fa-paint-brush';
    }

    protected function register_tab_controls(): void
    {
        $this->start_controls_section(
            'listivo_featured_listing_card',
            [
                'label' => esc_html__('Listivo Featured Ad Card', 'listivo-core'),
                'tab' => $this->get_id(),
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3--featured .listivo-listing-card-v3__inner' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4--featured .listivo-listing-card-v4__inner' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row--featured .listivo-listing-card-row__inner' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__inner' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_separator_color',
            [
                'label' => esc_html__('Separator', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3--featured .listivo-listing-card-v3__bottom' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4--featured .listivo-listing-card-v4__bottom' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row--featured .listivo-listing-card-row__bottom' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_featured_label_label',
            [
                'label' => esc_html__('Featured label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_featured_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3--featured .listivo-listing-card-v3__featured' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4--featured .listivo-listing-card-v4__featured' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row--featured .listivo-listing-card-row__featured' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__featured' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_featured_label_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3--featured .listivo-listing-card-v3__featured' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4--featured .listivo-listing-card-v4__featured' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row--featured .listivo-listing-card-row__featured' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__featured' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_border_label',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_border_width',
            [
                'label' => esc_html__('Width (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => $this->getBorderWidthSelectors(),
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_border_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__inner' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__gallery' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__gallery' => 'border-color: {{VALUE}} !important;',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__inner' => 'border-color: {{VALUE}} !important;',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_label_label',
            [
                'label' => esc_html__('Ad name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__name' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__name' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__name' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_address_icon_label',
            [
                'label' => esc_html__('Address icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_address_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__address-icon path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__address-icon path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__address-icon path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__address-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_address_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__address-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__address-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__address-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__address-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_address_label',
            [
                'label' => esc_html__('Address', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_address_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured  .listivo-listing-card-address-selector' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured  .listivo-listing-card-address-selector' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured  .listivo-listing-card-address-selector' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured  .listivo-listing-card-address-selector' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_price_label',
            [
                'label' => esc_html__('Price', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_price_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-value-selector' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-value-selector' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-value-selector' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-value-selector' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_attribute_label',
            [
                'label' => esc_html__('Attribute', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_attribute_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__attribute' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__attribute path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__attribute' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__attribute path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__category' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__category path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__attribute' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__attribute path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__attribute' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__attribute path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_attribute_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__attribute' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__attribute' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__attribute' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_account_type_label',
            [
                'label' => esc_html__('Account Type', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_account_type_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__account-type' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__account-type' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__account-type' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__account-type' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_user_label',
            [
                'label' => esc_html__('User', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_user_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-user-selector span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-user-selector span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-user-selector span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-user-selector span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_user_icon_color',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-user-icon-selector path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-user-icon-selector path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-user-icon-selector path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-user-icon-selector path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_user_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-user-icon-selector' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-user-icon-selector' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-user-icon-selector' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-user-icon-selector' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_icon_label',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row__icon:not(.listivo-listing-card-row-v2__icon--active, :hover) path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__icon:not(.listivo-listing-card-v3__icon--active, :hover) path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__icon:not(.listivo-listing-card-v3__icon--active, :hover) path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_icon_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__icon:not(.listivo-listing-card-row__icon--active, :hover)' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__icon:not(.listivo-listing-card-row__icon--active, :hover)' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__icon:not(.listivo-listing-card-v3__icon--active, :hover)' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__icon:not(.listivo-listing-card-v3__icon--active, :hover)' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_icon_border_views_label',
            [
                'label' => esc_html__('Views', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_listing_card_icon_border_views_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4--featured .listivo-listing-card-v4__views' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__views' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->addDescriptionControls();

        $this->addRatingStyleControls();

        $this->addMetaControls();

        $this->end_controls_section();
    }

    private function getBorderWidthSelectors(): array
    {
        $selectors = [
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured' => 'border: {{VALUE}}px solid;',
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__gallery' => 'border: {{VALUE}}px solid; border-bottom: 0;',
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4.listivo-listing-card-v4--featured .listivo-listing-card-v4__inner' => 'border: {{VALUE}}px solid; border-top: 0;',
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured' => 'border: {{VALUE}}px solid;',
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__gallery' => 'border: {{VALUE}}px solid; border-right-width: 0;',
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__inner' => 'border: {{VALUE}}px solid; border-left-width: 0;',
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__gallery' => 'border-radius: 0;',
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__gallery' => 'border-radius: 0;',
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v3.listivo-listing-card-v3--featured .listivo-listing-card-v3__inner' => 'border: 0;',
            '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row.listivo-listing-card-row--featured .listivo-listing-card-row__inner' => 'border: 0;',
        ];

        if (is_rtl()) {
            $selectors['{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__gallery'] = 'border-right-width: {{VALUE}}px; border-left-width: 0;';
            $selectors['{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2.listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__inner'] = 'border-left-width: {{VALUE}}px; border-right-width: 0;';
        }

        return $selectors;
    }

    private function addDescriptionControls(): void
    {
        $this->add_control(
            'listivo_featured_card_description_heading',
            [
                'label' => esc_html__('Description', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_card_description_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2--featured .listivo-listing-card-description-selector' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_featured_card_description_typo',
                'selector' => '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2--featured .listivo-listing-card-description-selector',
            ]
        );
    }

    private function addMetaControls(): void
    {
        $this->add_control(
            'featured_card_meta_style_heading',
            [
                'label' => esc_html__('Meta info', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'featured_card_meta_icon_color',
            [
                'label' => esc_html__('Icon color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__meta-icon path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4--featured .listivo-listing-card-v4__meta-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'featured_card_meta_icon_bg',
            [
                'label' => esc_html__('Icon background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__meta-icon' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4--featured .listivo-listing-card-v4__meta-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'featured_card_meta_text_color',
            [
                'label' => esc_html__('Text color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__meta-value' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-highlight-featured-listings .listivo-listing-card-v4--featured .listivo-listing-card-v4__meta-value' => 'color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addRatingStyleControls(): void
    {
        $this->add_control(
            'featured_card_rating_style_heading',
            [
                'label' => esc_html__('Rating', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'featured_card_rating_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4--featured .listivo-listing-card-v4__rating' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__rating' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'featured_card_rating_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $this->getWrapper() . ' .listivo-listing-card-v4--featured .listivo-listing-card-v4__rating, ' . $this->getWrapper() . ' .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__rating',
            ]
        );

        $this->add_control(
            'featured_card_rating_stars_heading',
            [
                'label' => esc_html__('Rating Stars', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('featured_card_rating_stars_tabs');

        $this->start_controls_tab(
            'featured_card_rating_stars_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'featured_card_rating_stars_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4--featured .listivo-listing-card-v4__stars .listivo-listing-card-v4__star:not(.listivo-listing-card-v4__star--active) path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__stars .listivo-listing-card-row-v2__star:not(.listivo-listing-card-row-v2__star--active) path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'featured_card_rating_stars_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4--featured .listivo-listing-card-v4__stars .listivo-listing-card-v4__star:not(.listivo-listing-card-v4__star--active) path' => 'stroke: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__stars .listivo-listing-card-row-v2__star:not(.listivo-listing-card-row-v2__star--active) path' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'featured_card_rating_stars_active_tab',
            [
                'label' => esc_html__('Active', 'listivo-core'),
            ]
        );

        $this->add_control(
            'featured_card_rating_stars_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4--featured .listivo-listing-card-v4__stars .listivo-listing-card-v4__star--active path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__stars .listivo-listing-card-row-v2__star--active path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'featured_card_rating_stars_active_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4--featured .listivo-listing-card-v4__stars .listivo-listing-card-v4__star--active path' => 'stroke: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__stars .listivo-listing-card-row-v2__star--active path' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'featured_card_reviews_number_heading',
            [
                'label' => esc_html__('Reviews number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'featured_card_reviews_number_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4--featured .listivo-listing-card-v4__rating-count' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__rating-count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'featured_card_reviews_number_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $this->getWrapper() . ' .listivo-listing-card-v4--featured .listivo-listing-card-v4__rating-count, ' . $this->getWrapper() . ' .listivo-listing-card-row-v2--featured .listivo-listing-card-row-v2__rating-count',
            ]
        );
    }

    private function getWrapper(): string
    {
        if (is_rtl()) {
            return '[dir] {{WRAPPER}} .listivo-highlight-featured-listings';
        }

        return '{{WRAPPER}} .listivo-highlight-featured-listings';
    }
}