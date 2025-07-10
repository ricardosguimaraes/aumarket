<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;
use Tangibledesign\Framework\Widgets\Helpers\Controls\CurrencyFieldsControl;

trait ListingMainValueControl
{
    use Control;
    use CurrencyFieldsControl;

    /**
     * @return Model|false
     */
    abstract public function getModel();

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