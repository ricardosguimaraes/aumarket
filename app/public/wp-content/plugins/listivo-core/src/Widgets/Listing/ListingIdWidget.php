<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

class ListingIdWidget extends BaseModelSingleWidget
{
    use TextControls;

    public function getKey(): string
    {
        return 'listing_id';
    }

    public function getName(): string
    {
        return esc_html__('Ad ID', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextControls($this->getSelector());

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function getSelector(): string
    {
        return '.listivo-listing-meta';
    }
}