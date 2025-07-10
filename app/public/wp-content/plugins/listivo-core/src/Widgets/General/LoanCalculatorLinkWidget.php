<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\PriceFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;

class LoanCalculatorLinkWidget extends BaseModelSingleWidget
{
    use TextControls;
    use PriceFieldControl;

    public const LABEL = 'label';

    public function getKey(): string
    {
        return 'loan_calculator_link';
    }

    public function getName(): string
    {
        return esc_html__('Loan Calculator Link', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addPriceFieldControl();

        $this->addLabelControl();

        $this->addTextControls('a');

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addLabelControl(): void
    {
        $this->add_control(
            self::LABEL,
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('calculate_financing'),
            ]
        );
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        $label = $this->get_settings_for_display(self::LABEL);

        if (empty($label)) {
            return tdf_string('calculate_financing');
        }

        return $label;
    }

    /**
     * @return bool
     */
    public function hasPrice(): bool
    {
        $listing = $this->getModel();
        $priceFields = $this->getPriceFields();
        if (!$listing || $priceFields->isEmpty()) {
            return false;
        }

        foreach ($priceFields as $priceField) {
            if (!empty($priceField->getValueByCurrency($listing))) {
                return true;
            }
        }

        return false;
    }

}