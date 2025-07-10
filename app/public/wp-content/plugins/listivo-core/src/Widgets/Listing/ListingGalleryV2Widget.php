<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\GalleryFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ImageSizeControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonTypeControl;

/**
 * Class ListingGalleryV2Widget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingGalleryV2Widget extends BaseModelSingleWidget
{
    use GalleryFieldControl;
    use ImageSizeControl;
    use ButtonTypeControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_gallery_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Gallery V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addButtonTypeControl();

        $this->addGalleryFieldControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return Collection|Image[]
     */
    public function getThumbnails(): Collection
    {
        return $this->getImages();
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        $count = $this->getImages()->count();

        if ($count > 5) {
            return 5;
        }

        return $count;
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

}