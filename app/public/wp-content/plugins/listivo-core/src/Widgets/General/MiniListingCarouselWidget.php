<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\QueryModelsControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SortByControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BoxArrowStyleControls;

class MiniListingCarouselWidget extends BaseGeneralWidget
{
    use SimpleLabelControl;
    use QueryModelsControl;
    use BoxArrowStyleControls;
    use SortByControls;

    public function getKey(): string
    {
        return 'mini_listing_carousel';
    }

    public function getName(): string
    {
        return esc_html__('Mini listing carousel', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->addQueryModelsControls();

        $this->addSortByControls(false);

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addLabelStyleControls();

        $this->addNameStyleControls();

        $this->addAddressStyleControls();

        $this->addAddressIconStyleControls();

        $this->addCountStyleControls();

        $this->addBoxArrowStyleControls();

        $this->endControlsSection();
    }

    private function addCountStyleControls():void
    {
        $this->add_control(
            'count_heading',
            [
                'label' => esc_html__('Count', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listing-carousel__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'count_typo',
                'selector' => '{{WRAPPER}} .listivo-mini-listing-carousel__count',
            ]
        );
    }

    private function addAddressIconStyleControls(): void
    {
        $this->add_control(
            'address_icon_heading',
            [
                'label' => esc_html__('Address icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'address_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listing-carousel-card__address-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'address_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listing-carousel-card__address-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addAddressStyleControls(): void
    {
        $this->add_control(
            'address_heading',
            [
                'label' => esc_html__('Address', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'address_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listing-carousel-card__address' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'address_typo',
                'selector' => '{{WRAPPER}} .listivo-mini-listing-carousel-card__address',
            ]
        );
    }

    private function addNameStyleControls(): void
    {
        $this->add_control(
            'name_heading',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listing-carousel-card__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'name_typo',
                'selector' => '{{WRAPPER}} .listivo-mini-listing-carousel-card__name',
            ]
        );
    }

    private function addLabelStyleControls(): void
    {
        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-mini-listing-carousel__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'label_typo',
                'selector' => '{{WRAPPER}} .listivo-mini-listing-carousel__label',
            ]
        );
    }

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
                    'slidesPerView' => 1,
                    'spaceBetween' => 30
                ],
                768 => [
                    'slidesPerView' => 2,
                    'spaceBetween' => 30
                ],
                1024 => [
                    'slidesPerView' => 1,
                    'spaceBetween' => 30
                ],
            ],
        ];
    }
}