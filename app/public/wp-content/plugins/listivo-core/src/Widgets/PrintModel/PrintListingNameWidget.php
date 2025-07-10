<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Tangibledesign\Framework\Widgets\Helpers\Controls\MarginControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

class PrintListingNameWidget extends BasePrintModelWidget
{
    use TextControls;
    use MarginControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'print_listing_name';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing Name', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextControls('.listivo-print-name');

        $this->addMarginControl('.listivo-print-name');

        $this->endControlsSection();
    }

}