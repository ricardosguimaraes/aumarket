<?php

namespace Tangibledesign\Listivo\Traits\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait ListingUserV2StyleControlsTrait
{
    use Control;

    private function addGeneralStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->addNameStyleControls();

        $this->addMemberSinceStyleControls();

        $this->addAccountTypeStyleControls();

        $this->addAddressStyleControls();

        $this->addSeeAllLinkStyleControls();

        $this->addButtonStyleControls();

        $this->endControlsSection();
    }

    private function addNameStyleControls(): void
    {
        $this->add_control(
            'name_heading',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'name_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__name',
            ]
        );
    }

    private function addMemberSinceStyleControls(): void
    {
        $this->add_control(
            'member_since_heading',
            [
                'label' => esc_html__('Member since', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'member_since_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__member-since' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'member_since_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__member-since',
            ]
        );
    }

    private function addAccountTypeStyleControls(): void
    {
        $this->add_control(
            'account_type_heading',
            [
                'label' => esc_html__('Account type', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'account_type_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__account-type' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'account_type_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__account-type',
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
                    '{{WRAPPER}} .listivo-listing-user-v2__address-text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'address_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__address-text',
            ]
        );

        $this->add_control(
            'address_icon_color',
            [
                'label' => esc_html__('Icon color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__address-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'address_icon_bg',
            [
                'label' => esc_html__('Icon background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__address-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addSeeAllLinkStyleControls(): void
    {
        $this->add_control(
            'see_all_heading',
            [
                'label' => esc_html__('See all link', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'see_all_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__see-all' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-listing-user-v2__see-all:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'see_all_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__see-all',
            ]
        );
    }

    private function addPhoneStyleSection(): void
    {
        $this->startStyleControlsSection('phone_style', esc_html__('Phone', 'listivo-core'));

        $this->add_control(
            'phone_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button--listing-user-v2' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'phone_icon_heading',
            [
                'label' => esc_html__('Phone icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'phone_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__icon:not(.listivo-contact-button__icon--additional) path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'phone_icon_bg',
            [
                'label' => esc_html__('Background-color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__icon:not(.listivo-contact-button__icon--additional)' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'phone_icon_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__icon:not(.listivo-contact-button__icon--additional)' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'phone_number_heading',
            [
                'label' => esc_html__('Number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'phone_number_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__inner' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'phone_number_star_color',
            [
                'label' => esc_html__('Star color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__inner span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'phone_number_typo',
                'selector' => '{{WRAPPER}} .listivo-contact-button__inner',
            ]
        );

        $this->add_control(
            'phone_eye_icon_heading',
            [
                'label' => esc_html__('Eye icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'phone_eye_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__icon--additional path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'phone_eye_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__icon--additional' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'phone_eye_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button__icon--additional' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addButtonStyleControls(): void
    {
        $this->add_control(
            'contact_button_heading',
            [
                'label' => esc_html__('Contact button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'contact_button_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-simple-button' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-simple-button__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'contact_button_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-simple-button' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }


    private function addUserStateStyleSection(): void
    {
        $this->startStyleControlsSection('user_state_style_section', esc_html__('Online / Offline', 'listivo-core'));

        $this->add_control(
            'user_state_online_heading',
            [
                'label' => esc_html__('Online', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'user_state_online_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__state--online' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-listing-user-v2__state--online:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_state_online_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__state--online',
            ]
        );

        $this->add_control(
            'user_state_offline_heading',
            [
                'label' => esc_html__('Offline', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'user_state_offline_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__state--offline' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-listing-user-v2__state--offline:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_state_offline_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__state--offline',
            ]
        );

        $this->endControlsSection();
    }

    private function addRatingStyleSection(): void
    {
        $this->startStyleControlsSection('rating_style_section', esc_html__('Rating', 'listivo-core'));

        $this->add_responsive_control(
            'rating_gap',
            [
                'label' => esc_html__('Gap', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__rating-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'rating_heading',
            [
                'label' => esc_html__('Rating', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'rating_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__rating' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rating_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__rating',
            ]
        );

        $this->add_control(
            'stars_heading',
            [
                'label' => esc_html__('Stars', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'rating_star_width',
            [
                'label' => esc_html__('Width (px)', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__star' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-listing-user-v2__star svg' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'rating_star_height',
            [
                'label' => esc_html__('Height (px)', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__stars' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-listing-user-v2__star' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-listing-user-v2__star svg' => 'height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->start_controls_tabs('stars_style_tabs');

        $this->start_controls_tab(
            'stars_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'stars_style_normal_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__stars .listivo-listing-user-v2__star:not(.listivo-listing-user-v2__star--active) path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'stars_style_normal_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__stars .listivo-listing-user-v2__star:not(.listivo-listing-user-v2__star--active) path' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'stars_style_active_tab',
            [
                'label' => esc_html__('Active', 'listivo-core'),
            ]
        );

        $this->add_control(
            'stars_style_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__stars .listivo-listing-user-v2__star--active path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'stars_style_active_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__stars .listivo-listing-user-v2__star--active path' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'rating_count_heading',
            [
                'label' => esc_html__('Ratings Number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('rating_count_style_tabs');

        $this->start_controls_tab(
            'rating_count_style_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'rating_count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__rating-count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rating_count_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__rating-count',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'rating_count_style_hover_tab',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'rating_count_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-user-v2__rating-count:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'rating_count_hover_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-user-v2__rating-count:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }
}