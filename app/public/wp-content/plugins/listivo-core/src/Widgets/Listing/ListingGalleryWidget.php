<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\GalleryFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ImageSizeControl;

/**
 * Class ListingGalleryWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingGalleryWidget extends BaseModelSingleWidget
{
    use GalleryFieldControl;
    use ImageSizeControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_gallery';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Gallery', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addGalleryFieldControl();

        $this->addImageSizeControl('listivo_375_240');

        $this->addHeightControl();

        $this->addNavigationStyleControls();

        $this->addImageNumberStyleControls();

        $this->addZoomStyleControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addHeightControl(): void
    {
        $this->add_responsive_control(
            'gallery_height',
            [
                'label' => esc_html__('Height', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-swiper-container' => 'height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-swiper-slide' => 'height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-listing-image' => 'height: {{SIZE}}{{UNIT}}; max-height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        $listing = $this->getModel();
        if (!$listing) {
            return tdf_collect();
        }

        $galleryField = $this->getGalleryField();
        if (!$galleryField) {
            return $listing->getImages();
        }

        return $galleryField->getImages($listing);
    }

    private function addImageNumberStyleControls(): void
    {
        $this->add_control(
            'image_number_heading',
            [
                'label' => esc_html__('Image number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'image_number_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-gallery-v1__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'image_number_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-gallery-v1__count' => 'background: {{VALUE}};',
                ]
            ]
        );
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
                    '{{WRAPPER}} .listivo-arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'navigation_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-arrow' => 'background: {{VALUE}};',
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
                    '{{WRAPPER}} .listivo-gallery-v1__zoom path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'zoom_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-gallery-v1__zoom' => 'background: {{VALUE}};',
                ]
            ]
        );
    }

}