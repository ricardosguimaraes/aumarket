<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Elementor\Controls_Manager;

/**
 * Class ListingGalleryV3Widget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingGalleryV3Widget extends ListingGalleryWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_gallery_v3';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Gallery V3', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addNavigationStyleControls();

        $this->addZoomStyleControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }


    private function addNavigationStyleControls(): void
    {
        $this->add_control(
            'navigation_heading',
            [
                'label' => esc_html__('Navigation', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'navigation_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-gallery-v3__arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'navigation_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-gallery-v3__arrow' => 'background: {{VALUE}};',
                ]
            ]
        );
    }

    private function addZoomStyleControls(): void
    {
        $this->add_control(
            'zoom_heading',
            [
                'label' => esc_html__('Zoom button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'zoom_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-gallery-v3__zoom path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'zoom_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-gallery-v3__zoom' => 'background: {{VALUE}};',
                ]
            ]
        );
    }

}