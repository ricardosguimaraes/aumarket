<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ModelTabsControl;
use Tangibledesign\Listivo\Widgets\Helpers\CardType;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HighlightFeaturedListingsControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\SlidesPerViewControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\TabsStyleControls;

class ListingCarouselWithTabsWidgetV2 extends BaseGeneralWidget
{
    use ModelTabsControl;
    use TabsStyleControls;
    use HighlightFeaturedListingsControl;
    use CardTypeControls;
    use SlidesPerViewControl;

    public function getKey(): string
    {
        return 'listing_carousel_with_tabs_v2';
    }

    public function getName(): string
    {
        return esc_html__('Listing Carousel With Tabs V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addModelTabsControls();

        $this->addSlidesPerViewControl();

        $this->addCardTypeControls(CardType::CARD_SMALL);

        $this->addShowFeaturedLabelControl();

        $this->addHighlightFeaturedListingsControl();

        $this->endControlsSection();

        $this->addTabsStyleSection();

        $this->addNavigationStyleSection();
    }

    /**
     * @return array
     */
    public function getSwiperConfig(): array
    {
        return [
            'loop' => false,
            'slidesPerView' => $this->getSlidesPerViewMobile(),
            'spaceBetween' => 20,
            'pagination' => [
                'el' => '.listivo-listing-carousel-with-tabs-v2__pagination',
                'type' => 'bullets'
            ],
            'breakpoints' => [
                768 => [
                    'slidesPerView' => $this->getSlidesPerViewTablet(),
                    'spaceBetween' => 30,
                ],
                1025 => [
                    'slidesPerView' => $this->getSlidesPerViewDesktop(),
                    'spaceBetween' => 30,
                ],
            ]
        ];
    }

    private function addNavigationStyleSection(): void
    {
        $this->startStyleControlsSection('listivo_nav_style', esc_html__('Navigation', 'listivo-core'));

        $this->add_control(
            'nav_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow path' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'nav_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-box-arrow' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->endControlsSection();
    }

}