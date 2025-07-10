<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\NumberFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

/**
 * Class ListingNumberFieldWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingNumberFieldWidget extends BaseModelSingleWidget
{
    use NumberFieldControl;
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_number_field';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Number Field', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addNumberFieldControl();

        $this->addTextControls($this->getSelector());

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    private function getSelector(): string
    {
        return '.listivo-listing__number-field';
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        $listing = $this->getModel();
        $numberField = $this->getNumberField();

        if (!$listing || !$numberField) {
            return '';
        }

        return $numberField->getValue($listing);
    }

}