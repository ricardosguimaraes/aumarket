<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

/**
 * Class ListingNameWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingNameWidget extends BaseModelSingleWidget
{
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_name';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Name', 'listivo-core');
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
        return '.listivo-listing__name';
    }

}