<?php


namespace Tangibledesign\Framework\Widgets\General;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

/**
 * Class TestimonialsWidget
 * @package Tangibledesign\Framework\Widgets
 */
abstract class TestimonialsWidget extends BaseGeneralWidget
{

    protected function addTestimonialsControl(): void
    {
        $testimonials = new Repeater();

        $testimonials->add_control(
            'name',
            [
                'label' => tdf_admin_string('name'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $testimonials->add_control(
            'job_title',
            [
                'label' => tdf_admin_string('job_title'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $testimonials->add_control(
            'image',
            [
                'label' => tdf_admin_string('image'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $testimonials->add_control(
            'text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $testimonials->add_control(
            'via',
            [
                'label' => tdf_admin_string('source'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $testimonials->add_control(
            'via_icon',
            [
                'label' => tdf_admin_string('icon'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $testimonials->add_control(
            'via_url',
            [
                'label' => tdf_admin_string('url'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => 'https://twitter.com/user/status/1441321552641880071'
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => tdf_admin_string('testimonials'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $testimonials->get_controls(),
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getTestimonials(): Collection
    {
        $testimonials = $this->get_settings_for_display('testimonials');

        if (empty($testimonials) || !is_array($testimonials)) {
            return tdf_collect();
        }

        return tdf_collect($testimonials)->map(static function ($testimonial) {
            $testimonial['image'] = tdf_image_factory()->create((int)$testimonial['image']['id']);
            $testimonial['via_icon'] = !empty($testimonial['via_icon']['value']) ? $testimonial['via_icon']['value'] : '';

            return $testimonial;
        });
    }

}