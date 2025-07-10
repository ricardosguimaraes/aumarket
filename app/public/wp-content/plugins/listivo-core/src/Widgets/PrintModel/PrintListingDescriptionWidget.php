<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Tangibledesign\Framework\Widgets\Helpers\Controls\MarginControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

class PrintListingDescriptionWidget extends BasePrintModelWidget
{
    use TextControls;
    use SimpleLabelControl;
    use MarginControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'print_listing_description';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing Description', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addLabelControl();

        $this->addTextControls('.listivo-print-description');

        $this->addMarginControl('.listivo-print-description-wrapper');

        $this->endControlsSection();
    }

}