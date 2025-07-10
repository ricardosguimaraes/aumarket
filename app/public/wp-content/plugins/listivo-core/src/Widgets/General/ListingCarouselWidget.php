<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\QueryModelsControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SortByControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\SlidesPerViewControl;

class ListingCarouselWidget extends BaseGeneralWidget
{
    use CardTypeControls;
    use HeadingV2Controls;
    use QueryModelsControl;
    use SlidesPerViewControl;
    use SortByControls;

    public function getKey(): string
    {
        return 'listing_carousel';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing carousel', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addSlidesPerViewControl();

        $this->addCardTypeControls();

        $this->addQueryModelsControls();

        $this->addSortByControls(false);

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addBoxArrowBackgroundColorControl();

        $this->endControlsSection();
    }

    private function addBoxArrowBackgroundColorControl(): void
    {
        $this->add_control(
            'box_arrow_bg_color',
            [
                'label' => esc_html__('Navigation background color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow' => 'background-color: {{VALUE}};'
                ]
            ]
        );
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
                499 => [
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