<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\TestimonialsV3Control;

class TestimonialsV3Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use TestimonialsV3Control;

    public function getKey(): string
    {
        return 'testimonials_v3';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Testimonials V3', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addTestimonialsControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addTestimonialStyleControls();

        $this->endControlsSection();
    }

    /**
     * @return array
     */
    public function getSwiperConfig(): array
    {
        return [
            'loop' => false,
            'slidesPerView' => 1,
            'spaceBetween' => 20,
            'breakpoints' => [
                768 => [
                    'slidesPerView' => 2,
                    'spaceBetween' => 30,
                ],
                1025 => [
                    'slidesPerView' => 3,
                    'spaceBetween' => 30,
                ],
            ]
        ];
    }

    private function addNavigationStyleControls(): void
    {
        $this->add_control(
            'nav_arrows_heading',
            [
                'label' => esc_html__('Navigation', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'nav_arrows_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'nav_arrows_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow' => 'background: {{VALUE}};'
                ]
            ]
        );
    }

}