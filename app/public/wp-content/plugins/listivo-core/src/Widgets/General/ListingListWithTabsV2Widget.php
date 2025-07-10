<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HighlightFeaturedListingsControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ListingGridControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\TabsStyleControls;

class ListingListWithTabsV2Widget extends ListingListWithTabsWidget
{
    use HeadingV2Controls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_list_with_tabs_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing List With Tabs V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addModelTabsControls();

        $this->addCardTypeControls();

        $this->addGridControls();

        $this->addShowFeaturedLabelControl();

        $this->addHighlightFeaturedListingsControl();

        $this->endControlsSection();

        $this->addTabsStyleSection();
    }

}