<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\RichTextFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

/**
 * Class ListingRichTextFieldWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingRichTextFieldWidget extends BaseModelSingleWidget
{
    use SimpleLabelControl;
    use RichTextFieldControl;
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_rich_text_field';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Rich Text Field', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addRichTextFieldControl();

        $this->addLabelControl();

        $this->addLabelStyleControls('.listivo-listing-section__label');

        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addTextControls($this->getSelector());

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    private function getSelector(): string
    {
        return '.listivo-listing-rich-text-field';
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        $listing = $this->getModel();
        $richTextField = $this->getRichTextField();

        if (!$listing || !$richTextField) {
            return '';
        }

        return $richTextField->getValue($listing);
    }

}