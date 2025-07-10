<?php


namespace Tangibledesign\Framework\Widgets\Helpers;


/**
 * Trait HasSwiper
 * @package Tangibledesign\Framework\Widgets\Helpers
 */
trait HasSwiper
{
    /**
     * @return array
     */
    public function getSwiperConfig(): array
    {
        return [
            'containerModifierClass' => tdf_prefix() . '-swiper-container-',
            'slideClass' => tdf_prefix() . '-swiper-slide',
            'slideActiveClass' => tdf_prefix() . '-swiper-slide-active',
            'slideDuplicateActiveClass' => tdf_prefix() . '-swiper-slide-duplicate-active',
            'slideVisibleClass' => tdf_prefix() . '-swiper-slide-visible',
            'slideDuplicateClass' => tdf_prefix() . '-swiper-slide-duplicate',
            'slideNextClass' => tdf_prefix() . '-swiper-slide-next',
            'slideDuplicateNextClass' => tdf_prefix() . '-swiper-slide-duplicate-next',
            'slidePrevClass' => tdf_prefix() . '-swiper-slide-prev',
            'slideDuplicatePrevClass' => tdf_prefix() . '-swiper-slide-duplicate-prev',
            'wrapperClass' => tdf_prefix() . '-swiper-wrapper',
        ];
    }

}