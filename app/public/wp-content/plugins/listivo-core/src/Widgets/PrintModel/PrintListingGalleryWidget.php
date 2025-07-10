<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\Controls\GalleryFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\MarginControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;

class PrintListingGalleryWidget extends BasePrintModelWidget
{
    use GalleryFieldControl;
    use SimpleLabelControl;
    use MarginControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'print_listing_gallery';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing Gallery', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControl();

        $this->addGalleryFieldControl();

        $this->addMarginControl('.listivo-print-images');

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