<?php


namespace Tangibledesign\Listivo\Widgets\Helpers;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\SlidesPerViewControl;

/**
 * Trait ListingCarousel
 * @package Tangibledesign\Listivo\Widgets\Helpers
 */
trait ListingCarousel
{
    use Control;
    use SlidesPerViewControl;

    protected function addHeadingControl(): void
    {
        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return (string)$this->get_settings_for_display('heading');
    }

    /**
     * @return array
     */
    public function getSwiperConfig(): array
    {
        return [
            'containerModifierClass' => 'listivo-swiper-container-',
            'slideClass' => 'listivo-swiper-slide',
            'slideActiveClass' => 'listivo-swiper-slide-active',
            'slideDuplicateActiveClass' => 'listivo-swiper-slide-duplicate-active',
            'slideVisibleClass' => 'listivo-swiper-slide-visible',
            'slideDuplicateClass' => 'listivo-swiper-slide-duplicate',
            'slideNextClass' => 'listivo-swiper-slide-next',
            'slideDuplicateNextClass' => 'listivo-swiper-slide-duplicate-next',
            'slidePrevClass' => 'listivo-swiper-slide-prev',
            'slideDuplicatePrevClass' => 'listivo-swiper-slide-duplicate-prev',
            'wrapperClass' => 'listivo-swiper-wrapper',
            'loop' => false,
            'spaceBetween' => 30,
            'breakpoints' => [
                0 => [
                    'slidesPerView' => $this->getSlidesPerViewMobile(),
                    'spaceBetween' => 30
                ],
                768 => [
                    'slidesPerView' => $this->getSlidesPerViewTablet(),
                    'spaceBetween' => 30
                ],
                1024 => [
                    'slidesPerView' => $this->getSlidesPerViewDesktop(),
                    'spaceBetween' => 30
                ],
            ],
        ];
    }

}