<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait TestimonialsV3Control
{
    use Control;

    protected function addTestimonialsControl(): void
    {
        $testimonials = new Repeater();

        $testimonials->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $testimonials->add_control(
            'avatar',
            [
                'label' => esc_html__('Avatar', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $testimonials->add_control(
            'author',
            [
                'label' => esc_html__('Author', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $testimonials->add_control(
            'job_title',
            [
                'label' => esc_html__('Job Title', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__('Testimonials', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $testimonials->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    public function getTestimonials(): array
    {
        $testimonials = $this->get_settings_for_display('testimonials');
        if (empty($testimonials) || !is_array($testimonials)) {
            return [];
        }

        return $testimonials;
    }

    protected function addTestimonialStyleControls(): void
    {
        $this->addAuthorStyleControls();

        $this->addJobTitleStyleControls();

        $this->addTextStyleControls();

        $this->addIconStyleControls();
    }

    protected function addIconStyleControls(): void
    {
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
                    '{{WRAPPER}} .listivo-testimonial-v3__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v3__icon' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ]
            ]
        );
    }

    protected function addAuthorStyleControls(): void
    {
        $this->add_control(
            'author_heading',
            [
                'label' => esc_html__('Author', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'author_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v3__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'author_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-testimonial-v3__name',
            ]
        );
    }

    protected function addJobTitleStyleControls(): void
    {
        $this->add_control(
            'job_title_heading',
            [
                'label' => esc_html__('Job title', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'job_title_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v3__job-title' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'job_title_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-testimonial-v3__job-title',
            ]
        );
    }


    protected function addTextStyleControls(): void
    {
        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v3__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Typography', '.listivo-core'),
                'selector' => '{{WRAPPER}} listivo-testimonial-v3__text',
            ]
        );
    }
}