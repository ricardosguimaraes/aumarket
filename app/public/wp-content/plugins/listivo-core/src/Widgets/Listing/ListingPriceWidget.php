<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ListingMainValueControl;

class ListingPriceWidget extends BaseModelSingleWidget
{
    use ListingMainValueControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_price';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Price', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addCurrencyFieldsControl();

        $this->addTextWhenEmptyControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addStyleControls();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addTextWhenEmptyControl(): void
    {
        $this->add_control(
            'text_when_empty',
            [
                'label' => esc_html__('Text When Empty', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    public function getTextWhenEmpty(): string
    {
        return (string)$this->get_settings_for_display('text_when_empty');
    }

    private function addStyleControls(): void
    {
        $this->add_control(
            'color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-price' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'price_typo',
                'selector' => '{{WRAPPER}} .listivo-listing-price',
            ]
        );
    }
}