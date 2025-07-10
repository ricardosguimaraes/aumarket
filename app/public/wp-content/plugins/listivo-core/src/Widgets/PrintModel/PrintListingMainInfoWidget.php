<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Tangibledesign\Framework\Widgets\Helpers\Controls\CurrencyFieldsControl;

class PrintListingMainInfoWidget extends BasePrintModelWidget
{
    use CurrencyFieldsControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'print_listing_main_info';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Listing Main Info', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addCurrencyFieldsControl();

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

    /**
     * @return string
     */
    public function getAddress(): string
    {
        $listing = $this->getModel();
        if (!$listing) {
            return '';
        }

        return $listing->getAddress();
    }

}