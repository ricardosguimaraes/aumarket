<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\GalleryFieldControl;

class ListingImageWidget extends BaseModelSingleWidget
{
    use GalleryFieldControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_image';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Image', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addGalleryFieldControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    public function getImage()
    {
        $listing = $this->getModel();
        if (!$listing) {
            return false;
        }

        $galleryField = $this->getGalleryField();
        if (!$galleryField) {
            return $listing->getMainImage();
        }

        return $galleryField->getImage($listing);
    }

}