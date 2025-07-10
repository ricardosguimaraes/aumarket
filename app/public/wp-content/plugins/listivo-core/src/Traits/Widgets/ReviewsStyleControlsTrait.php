<?php

namespace Tangibledesign\Listivo\Traits\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonTypeControl;

trait ReviewsStyleControlsTrait
{
    use Control;
    use ButtonTypeControl;

    protected function addReviewsBaseListStyleSection(): void
    {
        $this->startStyleControlsSection('reviews_base_list_style', esc_html__('Reviews Base List', 'listivo-core'));

        $this->add_control(
            'review_base_list_top_bg',
            [
                'label' => esc_html__('Top Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__top' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_base_list_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_base_list_separator_color',
            [
                'label' => esc_html__('Separator Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review' => 'border-bottom-color: {{VALUE}}',
                    '{{WRAPPER}} .listivo-reviews__top' => 'border-bottom-color: {{VALUE}}',
                    '{{WRAPPER}} .listivo-reviews__button-wrapper' => 'border-top-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_base_list_label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_base_list_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_base_list_label_typography',
                'selector' => '{{WRAPPER}} .listivo-reviews__title',
            ]
        );

        $this->add_control(
            'review_base_list_count_heading',
            [
                'label' => esc_html__('Reviews Number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_base_list_count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__count' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_base_list_count_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__count' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_base_list_count_typography',
                'selector' => '{{WRAPPER}} .listivo-reviews__count',
            ]
        );

        $this->add_control(
            'review_base_list_rating_heading',
            [
                'label' => esc_html__('Rating', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_base_list_rating_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__rating' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_base_list_rating_typography',
                'selector' => '{{WRAPPER}} .listivo-reviews__rating',
            ]
        );

        $this->add_control(
            'review_base_list_star_heading',
            [
                'label' => esc_html__('Star', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('review_base_list_star_tabs');

        $this->start_controls_tab(
            'review_base_list_star_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_base_list_star_normal_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__star:not(.listivo-reviews__star--active) path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_base_list_star_normal_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__star:not(.listivo-reviews__star--active) path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'review_base_list_star_active_tab',
            [
                'label' => esc_html__('Active', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_base_list_star_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__star--active path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_base_list_star_active_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__star--active path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'review_base_list_button_heading',
            [
                'label' => esc_html__('Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_base_list_button_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__button' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_base_list_button_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__button' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_base_list_button_typography',
                'selector' => '{{WRAPPER}} .listivo-reviews__button',
            ]
        );

        $this->add_control(
            'review_base_list_button_count_heading',
            [
                'label' => esc_html__('Button Reviews Number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_base_list_button_count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__button span' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_base_list_button_count_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-reviews__button span' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_base_list_button_count_typography',
                'selector' => '{{WRAPPER}} .listivo-reviews__button span',
            ]
        );

        $this->endControlsSection();
    }

    protected function addReviewStyleSection(): void
    {
        $this->startStyleControlsSection('review_style', esc_html__('Review', 'listivo-core'));

        $this->add_control(
            'review_user_name_heading',
            [
                'label' => esc_html__('User Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_user_name_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review__user-heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_user_name_typography',
                'selector' => '.listivo-review__user-heading',
            ]
        );

        $this->add_control(
            'review_user_subheading_heading',
            [
                'label' => esc_html__('User Subheading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_user_subheading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review__user-subheading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_user_subheading_typography',
                'selector' => '.listivo-review__user-subheading',
            ]
        );


        $this->add_control(
            'review_star_rating_heading',
            [
                'label' => esc_html__('Star Rating', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('review_star_rating_tabs');

        $this->start_controls_tab(
            'review_star_rating_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_star_rating_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review__star:not(.listivo-review__star--active) path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_star_rating_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review__star:not(.listivo-review__star--active) path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'review_star_rating_active_tab',
            [
                'label' => esc_html__('Active', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_star_rating_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review__star--active path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_star_rating_active_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review__star--active path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'review_text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_text_typography',
                'selector' => '.listivo-review__text',
            ]
        );

        $this->add_control(
            'review_thumbs_heading',
            [
                'label' => esc_html__('Thumbs', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('review_thumbs_tabs');

        $this->start_controls_tab(
            'review_thumbs_normal',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_thumbs_normal_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active)' => 'color: {{VALUE}};',
                    '.listivo-review-thumb:not(.listivo-review-thumb--active) .listivo-review-thumb__count' => 'color: {{VALUE}};',
                    '.listivo-review-thumb:not(.listivo-review-thumb--active) path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'review_thumbs_normal_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active)' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'review_thumbs_normal_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active)' => 'border-color: {{VALUE}};',
                    '.listivo-review-thumb:not(.listivo-review-thumb--active) .listivo-review-thumb__icon' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'review_thumbs_hover',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_thumbs_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover' => 'color: {{VALUE}};',
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover .listivo-review-thumb__count' => 'color: {{VALUE}};',
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'review_thumbs_hover_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'review_thumbs_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover' => 'border-color: {{VALUE}};',
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover .listivo-review-thumb__icon' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'review_thumb_hover_icon_heading',
            [
                'label' => esc_html__('Hover Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('review_thumb_hover_icon_tabs');

        $this->start_controls_tab(
            'review_thumb_hover_icon_up_tab',
            [
                'label' => esc_html__('Up', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_thumb_up_hover_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover.listivo-review-thumb--up .listivo-review-thumb__icon' => 'border-color: {{VALUE}};',
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover.listivo-review-thumb--up path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'review_thumb_up_hover_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover.listivo-review-thumb--up .listivo-review-thumb__icon' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'review_thumb_hover_icon_down_tab',
            [
                'label' => esc_html__('Down', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_thumb_down_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover.listivo-review-thumb--down .listivo-review-thumb__icon' => 'border-color: {{VALUE}};',
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover.listivo-review-thumb--down path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'review_thumb_down_hover_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb:not(.listivo-review-thumb--active):hover.listivo-review-thumb--down .listivo-review-thumb__icon' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'review_thumb_active_icon_heading',
            [
                'label' => esc_html__('Active Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('review_thumb_active_icon_tabs');

        $this->start_controls_tab(
            'review_thumb_up_active_icon_tab',
            [
                'label' => esc_html__('Up', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_thumb_up_active_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb--active.listivo-review-thumb--up' => 'color: {{VALUE}};',
                    '.listivo-review-thumb--active.listivo-review-thumb--up .listivo-review-thumb__count' => 'color: {{VALUE}};',
                    '.listivo-review-thumb--active.listivo-review-thumb--up path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'review_thumb_up_active_icon_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb--active.listivo-review-thumb--up .listivo-review-thumb__icon' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'review_thumb_down_active_icon_tab',
            [
                'label' => esc_html__('Down', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_thumb_down_active_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb--active.listivo-review-thumb--down' => 'color: {{VALUE}};',
                    '.listivo-review-thumb--active.listivo-review-thumb--down .listivo-review-thumb__count' => 'color: {{VALUE}};',
                    '.listivo-review-thumb--active.listivo-review-thumb--down path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'review_thumb_down_active_icon_bg',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-review-thumb--active.listivo-review-thumb--down .listivo-review-thumb__icon' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }

    protected function addReviewFormStyleSection(): void
    {
        $this->startStyleControlsSection('review_form_style', esc_html__('Review Form', 'listivo-core'));

        $this->add_control(
            'review_form_background_color',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'review_form_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'review_form_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .listivo-review-form__top' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_form_heading_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_form_heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__title' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_form_heading_typography',
                'selector' => '{{WRAPPER}} .listivo-review-form__title',
            ]
        );

        $this->add_control(
            'review_form_star_rating_heading',
            [
                'label' => esc_html__('Star Rating', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('review_form_star_rating_tabs');

        $this->start_controls_tab(
            'review_form_star_rating_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_form_star_rating_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__star:not(.listivo-review-form__star--hover, .listivo-review-form__star--active) path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_form_star_rating_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__star:not(.listivo-review-form__star--hover, .listivo-review-form__star--active) path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'review_form_star_rating_hover_tab',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_form_star_rating_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__star--hover path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_form_star_rating_hover_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__star--hover path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'review_form_star_rating_active_tab',
            [
                'label' => esc_html__('Active', 'listivo-core'),
            ]
        );

        $this->add_control(
            'review_form_star_rating_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__star--active path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'review_form_star_rating_active_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__star--active path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'review_form_user_name_heading',
            [
                'label' => esc_html__('User Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_form_user_name_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__user-heading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_form_user_name_typography',
                'selector' => '{{WRAPPER}} .listivo-review-form__user-heading',
            ]
        );

        $this->add_control(
            'review_form_user_subheading_heading',
            [
                'label' => esc_html__('User Subheading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_form_user_subheading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__user-subheading' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_form_user_subheading_typography',
                'selector' => '{{WRAPPER}} .listivo-review-form__user-subheading',
            ]
        );

        $this->add_control(
            'review_form_image_upload_label_heading',
            [
                'label' => esc_html__('Images Upload Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_form_image_upload_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__attachments-label' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-review-form__attachments-label path' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_form_image_upload_label_typography',
                'selector' => '{{WRAPPER}} .listivo-review-form__attachments-label',
            ]
        );

        $this->add_control(
            'review_form_textarea_heading',
            [
                'label' => esc_html__('Textarea', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'review_form_textarea_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__textarea' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'review_form_textarea_typography',
                'selector' => '{{WRAPPER}} .listivo-review-form__textarea, {{WRAPPER}} .listivo-review-form__textarea::placeholder',
            ]
        );

        $this->add_control(
            'review_form_textarea_background_color',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__textarea' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'review_form_textarea_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'review_form_textarea_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-review-form__textarea' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->addButtonTypeControl();

        $this->endControlsSection();
    }

    protected function addReviewsModalStyleSection(): void
    {
        $this->startStyleControlsSection('reviews_modal_style', esc_html__('Reviews Modal', 'listivo-core'));

        $this->add_control(
            'reviews_modal_header_background',
            [
                'label' => esc_html__('Header Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal__head' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'reviews_modal_filters_background',
            [
                'label' => esc_html__('Filters Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal__filters' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'reviews_modal_background_color',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal___content' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'reviews_modal_label_heading',
            [
                'label' => esc_html__('Reviews Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'reviews_modal_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal__label' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'reviews_modal_label_typography',
                'selector' => '.listivo-reviews-modal__label',
            ]
        );

        $this->add_control(
            'reviews_modal_number_heading',
            [
                'label' => esc_html__('Reviews Number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'reviews_modal_number_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal__label span' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'reviews_modal_number_background_color',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal__label span' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'reviews_modal_rating_heading',
            [
                'label' => esc_html__('Rating', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'reviews_modal_rating_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal__rating' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'reviews_modal_rating_typography',
                'selector' => '.listivo-reviews-modal__rating',
            ]
        );

        $this->add_control(
            'reviews_modal_star_heading',
            [
                'label' => esc_html__('Star Rating', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('reviews_modal_star_rating_tabs');

        $this->start_controls_tab(
            'reviews_modal_star_rating_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'reviews_modal_star_rating_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal__star' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'reviews_modal_star_rating_active_tab',
            [
                'label' => esc_html__('Active', 'listivo-core'),
            ]
        );

        $this->add_control(
            'reviews_modal_star_rating_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal__star--active' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'reviews_modal_filter_label_heading',
            [
                'label' => esc_html__('Filter Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'reviews_modal_filter_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-reviews-modal__filter-label' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'reviews_modal_filter_label_typography',
                'selector' => '.listivo-reviews-modal__filter-label',
            ]
        );

        $this->endControlsSection();
    }

    private function addUserAvatarPlaceholderStyleSection(): void
    {
        $this->startStyleControlsSection('user_avatar_placeholder_style', esc_html__('User Avatar Placeholder', 'listivo-core'));

        $this->add_control(
            'user_avatar_placeholder_background_color',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'separator' => 'before',
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-image-placeholder' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'user_avatar_placeholder_color',
            [
                'label' => esc_html__('Icon Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-image-placeholder path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->endControlsSection();
    }
}