<?php

namespace Tangibledesign\Listivo\Widgets\Listing;


use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;

class ListingPrintWidget extends BaseModelSingleWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_print';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Print', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->addVisibilitySection();
    }

}