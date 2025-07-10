<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\General\BaseLoanCalculatorWidget;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;

class LoanCalculatorWidget extends BaseLoanCalculatorWidget
{
    use HasModel;

    protected function register_controls(): void
    {
        parent::register_controls();

        $this->startStyleControlsSection();

        $this->addBackgroundControl();

        $this->addBorderColorControl();

        $this->addHeadingStyleControls();

        $this->addFieldLabelStyleControls();

        $this->addInfoBoxStyleControls();

        $this->addTotalStyleControls();

        $this->addMarginControl();

        $this->endControlsSection();
    }

    private function addBorderColorControl(): void
    {
        $this->add_control(
            'border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator' => 'border-color: {{VALUE}};'
                ]
            ]
        );
    }

    private function addBackgroundControl(): void
    {
        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'loan_calculator_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    /**
     * @return float|int|string
     */
    public function getInitialPrice()
    {
        if (!is_singular(tdf_model_post_type())) {
            return parent::getInitialPrice();
        }

        $listing = $this->getModel();
        $priceFields = $this->getPriceFields();

        if (!$listing || $priceFields->isEmpty()) {
            return parent::getInitialPrice();
        }

        foreach ($priceFields as $priceField) {
            $price = $priceField->getRawValueByCurrency($listing);
            if (!empty($price)) {
                return $price;
            }
        }

        return '';
    }

    public function getDownPayment(): int
    {
        if (!$this->isDynamicDownPaymentEnabled() || !is_singular(tdf_model_post_type())) {
            return parent::getDownPayment();
        }

        $price = $this->getListingPrice();
        if (empty($price)) {
            return parent::getDownPayment();
        }

        return $price * $this->getDynamicDownPaymentValue();
    }

    private function getListingPrice(): string
    {
        $listing = $this->getModel();
        $priceFields = $this->getPriceFields();

        if (!$listing || $priceFields->isEmpty()) {
            return '';
        }

        foreach ($priceFields as $priceField) {
            $price = $priceField->getRawValueByCurrency($listing);
            if (!empty($price)) {
                return $price;
            }
        }

        return '';
    }

    private function addTotalStyleControls(): void
    {
        $this->add_control(
            'total_heading',
            [
                'label' => esc_html__('Total payments', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'total_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator__result--primary' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'total_value_color',
            [
                'label' => esc_html__('Value color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator__result--primary span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'total_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator__result--primary' => 'background: {{VALUE}};',
                ]
            ]
        );
    }

    private function addHeadingStyleControls(): void
    {
        $this->add_control(
            'heading_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator__heading' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-loan-calculator__heading',
            ]
        );
    }

    private function addFieldLabelStyleControls(): void
    {
        $this->add_control(
            'field_label_heading',
            [
                'label' => esc_html__('Field label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'field_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-field-group__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'field_label_required_color',
            [
                'label' => esc_html__('Required color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-field-group__label span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_label_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-field-group__label',
            ]
        );
    }

    private function addInfoBoxStyleControls(): void
    {
        $this->add_control(
            'information_heading',
            [
                'label' => esc_html__('Information box', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'information_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator__result' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'information_value_color',
            [
                'label' => esc_html__('Value color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator__result span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'information_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-loan-calculator__result' => 'background: {{VALUE}};',
                ]
            ]
        );
    }
}