<?php

namespace Tangibledesign\Listivo\Traits\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait RatingStyleControlsTrait
{
    use Control;

    protected function addRatingStyleSection(): void
    {
        $this->startStyleControlsSection('rating_style', esc_html__('Rating', 'listivo-core'));

        $this->add_control(
            'rating_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-rating__rating' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'rating_typography',
                'selector' => '{{WRAPPER}} .listivo-rating__rating',
            ]
        );

        $this->endControlsSection();
    }

    protected function addStarsStyleSection(): void
    {
        $this->startStyleControlsSection('rating_stars_style', esc_html__('Stars', 'listivo-core'));

        $this->start_controls_tabs('rating_stars_tabs');

        $this->add_responsive_control(
            'rating_star_width',
            [
                'label' => esc_html__('Width', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-rating__star' => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-rating__star svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'rating_star_height',
            [
                'label' => esc_html__('Height', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-rating__star' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-rating__star svg' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tab(
            'rating_stars_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'rating_stars_normal_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-rating__star:not(.listivo-rating__star--active) path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'rating_stars_normal_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-rating__star:not(.listivo-rating__star--active) path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'rating_stars_active_tab',
            [
                'label' => esc_html__('Active', 'listivo-core'),
            ]
        );

        $this->add_control(
            'rating_stars_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-rating__star--active path' => 'fill: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'rating_stars_active_border_color',
            [
                'label' => esc_html__('Border Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-rating__star--active path' => 'stroke: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }

    protected function addRatingCountStyleSection(): void
    {
        $this->startStyleControlsSection('rating_count_style', esc_html__('Count', 'listivo-core'));

        $this->start_controls_tabs('rating_count_tabs');

        $this->start_controls_tab(
            'rating_count_normal_tab',
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
                    '{{WRAPPER}} .listivo-rating__count' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'rating_count_typography',
                'selector' => '{{WRAPPER}} .listivo-rating__count',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'rating_count_hover_tab',
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
                    '{{WRAPPER}} .listivo-rating__count--clickable:hover' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'rating_count_hover_typography',
                'selector' => '{{WRAPPER}} .listivo-rating__count--clickable:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }
}