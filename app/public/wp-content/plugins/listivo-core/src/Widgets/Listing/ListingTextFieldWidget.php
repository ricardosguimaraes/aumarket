<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextFieldControl;

/**
 * Class ListingTextFieldWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingTextFieldWidget extends BaseModelSingleWidget
{
    use TextFieldControl;
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_text_field';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Text Field', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextFieldControl();

        $this->addTextControls($this->getSelector());

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    private function getSelector(): string
    {
        return '.listivo-listing__text-field';
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        $listing = $this->getModel();
        $textField = $this->getTextField();

        if (!$listing || !$textField) {
            return '';
        }

        return $textField->getValue($listing);
    }

}