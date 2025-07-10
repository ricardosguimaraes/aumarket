<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ModelTabsControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\CardTypeControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HighlightFeaturedListingsControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ListingGridControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\TabsStyleControls;

class ListingListWithTabsWidget extends BaseGeneralWidget
{
    use ModelTabsControl;
    use TabsStyleControls;
    use HighlightFeaturedListingsControl;
    use CardTypeControls;
    use ListingGridControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_list_with_tabs';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing List With Tabs', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addCardTypeControls();

        $this->addShowFeaturedLabelControl();

        $this->addHighlightFeaturedListingsControl();

        $this->addGridControls();

        $this->addModelTabsControls();

        $this->endControlsSection();

        $this->addTabsStyleSection();
    }

}