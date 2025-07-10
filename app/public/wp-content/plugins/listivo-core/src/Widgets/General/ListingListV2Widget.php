<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SortByControls;
use Tangibledesign\Listivo\Traits\Widgets\AdCardConfigTrait;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HighlightFeaturedListingsControl;

class ListingListV2Widget extends ListingListWidget
{
    use HeadingV2Controls;
    use HighlightFeaturedListingsControl;
    use CardTypeControls;
    use SortByControls;
    use AdCardConfigTrait;

    public function getKey(): string
    {
        return 'listing_list_v2';
    }

    public function getName(): string
    {
        return esc_html__('Ad List V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addCardTypeControls();

        $this->addLimitControl();

        $this->addSortByControls(false);

        $this->addGridControls('.listivo-listing-list-v2__content');

        $this->addTermsControl();

        $this->addFeaturedOnlyControl();

        $this->addButtonHeading();

        $this->addButtonTextControl();

        $this->addButtonDestinationControl();

        $this->addShowDecorationControl();

        $this->addShowFeaturedLabelControl();

        $this->addHighlightFeaturedListingsControl();

        $this->addIncludeExcludedControl();

        $this->endControlsSection();
    }
}