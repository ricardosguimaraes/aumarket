<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\Controls\GalleryFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\MarginControl;

class PrintListingImageWidget extends BasePrintModelWidget
{
    use GalleryFieldControl;
    use MarginControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'print_listing_image';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing Image', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addMarginControl('.listivo-print-image');

        $this->addGalleryFieldControl();

        $this->endControlsSection();
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

        return $this->getGalleryFieldImages($listing);
    }

}