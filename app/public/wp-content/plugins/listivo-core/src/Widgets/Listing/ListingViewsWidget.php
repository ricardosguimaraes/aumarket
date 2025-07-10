<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

/**
 * Class ListingViewsWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingViewsWidget extends BaseModelSingleWidget
{
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_views';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Views', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextControls($this->getSelector());

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    private function getSelector(): string
    {
        return '.listivo-listing-meta';
    }

}