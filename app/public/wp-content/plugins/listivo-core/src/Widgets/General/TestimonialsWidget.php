<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Tangibledesign\Framework\Widgets\Helpers\Controls\CarouselControls;

/**
 * Class TestimonialsWidget
 * @package Tangibledesign\Listivo\Widgets
 */
class TestimonialsWidget extends \Tangibledesign\Framework\Widgets\General\TestimonialsWidget
{
    use CarouselControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'testimonials';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Testimonials', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTestimonialsControl();

        $this->addAutoPlayControl();

        $this->endControlsSection();
    }

    /**
     * @return array
     */
    public function getSwiperConfig(): array
    {
        $config = [
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
            'slidesPerView' => 3,
            'spaceBetween' => 35,
            'loop' => true,
            'observer' => true,
            'observeParents' => true,
            'centeredSlides' => true,
            'slideToClickedSlide' => true,
            'breakpoints' => [
                0 => [
                    'slidesPerView' => 1,
                    'spaceBetween' => 15
                ],
                768 => [
                    'slidesPerView' => 2,
                    'spaceBetween' => 30
                ],
                1280 => [
                    'slidesPerView' => 3,
                    'spaceBetween' => 30
                ],
            ],
        ];

        if ($this->isAutoplayEnabled()) {
            $config['autoplay'] = [
                'delay' => $this->getAutoplayDelay()
            ];
        }

        return $config;
    }

}