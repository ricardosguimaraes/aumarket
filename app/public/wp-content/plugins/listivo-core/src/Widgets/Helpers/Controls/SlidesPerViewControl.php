<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait SlidesPerViewControl
{
    use Control;

    protected function addSlidesPerViewControl(
        string $default = '4_slide',
        string $tabletDefault = '2.5_slide',
        string $mobileDefault = '1.25_slide'
    ): void
    {
        $this->add_responsive_control(
            'slides_per_view',
            [
                'label' => esc_html__('Slides per view', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    '1_slide' => esc_html__('1', 'listivo-core'),
                    '1.25_slide' => esc_html__('1.25', 'listivo-core'),
                    '1.5_slide' => esc_html__('1.5', 'listivo-core'),
                    '1.75_slide' => esc_html__('1.75', 'listivo-core'),
                    '2_slide' => esc_html__('2', 'listivo-core'),
                    '2.5_slide' => esc_html__('2.5', 'listivo-core'),
                    '3_slide' => esc_html__('3', 'listivo-core'),
                    '3.5_slide' => esc_html__('3.5', 'listivo-core'),
                    '4_slide' => esc_html__('4', 'listivo-core'),
                    '4.5_slide' => esc_html__('4.5', 'listivo-core'),
                    '5_slide' => esc_html__('5', 'listivo-core'),
                ],
                'default' => $default,
                'tablet_default' => $tabletDefault,
                'mobile_default' => $mobileDefault,
            ]
        );
    }

    public function getSlidesPerViewDesktop(): float
    {
        $value = (string)$this->get_settings_for_display('slides_per_view');
        if (empty($value)) {
            return 4;
        }

        return (float)str_replace('_slide', '', $value);
    }

    public function getSlidesPerViewTablet(): float
    {
        $value = (string)$this->get_settings_for_display('slides_per_view_tablet');
        if (empty($value)) {
            return 2.5;
        }

        return (float)str_replace('_slide', '', $value);
    }

    public function getSlidesPerViewMobile(): float
    {
        $value = (string)$this->get_settings_for_display('slides_per_view_mobile');
        if (empty($value)) {
            return 1.25;
        }

        return (float)str_replace('_slide', '', $value);
    }
}