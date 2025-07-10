<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Tangibledesign\Framework\Widgets\Helpers\Controls\CurrencyFieldsControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

class PrintListingPriceWidget extends BasePrintModelWidget
{
    use CurrencyFieldsControl;
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'print_listing_price';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing Price', 'listivo-core');
    }


    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addCurrencyFieldsControl();

        $this->addTextControls('.listivo-print-price-wrapper');

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    public function getMainValue(): string
    {
        $listing = $this->getModel();
        if (!$listing) {
            return '';
        }

        $currencyFields = $this->getCurrencyFields();
        if ($currencyFields->isEmpty()) {
            return '';
        }

        foreach ($currencyFields as $currencyField) {
            $value = $currencyField->getValueByCurrency($listing);
            if (!empty($value)) {
                return $value;
            }
        }

        return '';
    }

}