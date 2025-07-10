<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextareaControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class TestimonialsV2Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use TextareaControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'testimonials_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Testimonials V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addTextControl();

        $this->addTestimonialsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addHeadingStyleControls();

        $this->addTextColorControl();

        $this->addArrowsControls();

        $this->endControlsSection();

        $this->startStyleControlsSection('testimonial', esc_html__('Testimonial', 'listivo-core'));

        $this->addTestimonialStyleControls();

        $this->endControlsSection();
    }

    protected function addTestimonialsControl(): void
    {
        $testimonials = new Repeater();

        $testimonials->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

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

    /**
     * @return array
     */
    public function getTestimonials(): array
    {
        $testimonials = $this->get_settings_for_display('testimonials');
        if (empty($testimonials) || !is_array($testimonials)) {
            return [];
        }

        return $testimonials;
    }

    private function addHeadingStyleControls(): void
    {
        $this->add_control(
            'small_heading_label',
            [
                'label' => esc_html__('Small heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'small_heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-heading-v2__small-text' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'small_heading_bg_color',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-heading-v2__small-text' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'heading_label',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-heading-v2__text' => 'color: {{VALUE}};'
                ]
            ]
        );
    }

    private function addTextColorControl(): void
    {

        $this->add_control(
            'text_style_label',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Text color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonials-v2__text' => 'color: {{VALUE}};'
                ]
            ]
        );
    }

    private function addArrowsControls(): void
    {
        $this->add_control(
            'arrows_label',
            [
                'label' => esc_html__('Arrows', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'arrows_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow' => 'background-color: {{VALUE}};'
                ]
            ]
        );
    }

    private function addTestimonialStyleControls(): void
    {
        $this->add_control(
            'testimonial_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v2' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'testimonial_border',
                'label' => esc_html__('Border', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-testimonial-v2',
            ]
        );

        $this->add_control(
            'testimonial_title_color',
            [
                'label' => esc_html__('Title', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v2__heading' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'testimonial_text_color',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v2__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'testimonial_icon_color',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v2__icon path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'testimonial_line_color',
            [
                'label' => esc_html__('Line', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v2__icon' => 'border-color: {{VALUE}}; background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-testimonial-v2__bottom' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'testimonial_name_color',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v2__name' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'testimonial_job_title_color',
            [
                'label' => esc_html__('Job title', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-testimonial-v2__job-title' => 'color: {{VALUE}};'
                ]
            ]
        );
    }
}