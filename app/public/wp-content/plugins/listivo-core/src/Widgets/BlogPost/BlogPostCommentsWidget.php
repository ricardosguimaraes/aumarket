<?php

namespace Tangibledesign\Listivo\Widgets\BlogPost;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BasePostSingleWidget;

class BlogPostCommentsWidget extends BasePostSingleWidget
{
    public function getKey(): string
    {
        return 'blog_post_comments';
    }

    public function getName(): string
    {
        return tdf_admin_string('blog_post_comments');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'count_heading',
            [
                'label' => esc_html__('Count', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-comments__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'count_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-comments__count' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-comment__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-comment__icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'input_icon',
            [
                'label' => esc_html__('Input icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'input_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-comment-form__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'input_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-comment-form__icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }
}