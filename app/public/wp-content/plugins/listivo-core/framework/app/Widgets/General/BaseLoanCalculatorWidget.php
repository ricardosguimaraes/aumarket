<?php

namespace Tangibledesign\Framework\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\PriceFieldControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

abstract class BaseLoanCalculatorWidget extends BaseGeneralWidget
{
    use PriceFieldControl;

    public const PRICE = 'price';
    public const RATE = 'rate';
    public const MONTHS = 'months';
    public const DOWN_PAYMENT = 'down_payment';
    public const DYNAMIC_DOWN_PAYMENT = 'dynamic_down_payment';
    public const DYNAMIC_DOWN_PAYMENT_PERCENTAGE = 'dynamic_down_payment_percentage';

    public function getKey(): string
    {
        return 'loan_calculator';
    }

    public function getName(): string
    {
        return tdf_admin_string('loan_calculator');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addPriceFieldControl();

        $this->addInitialPriceControl();

        $this->addInitialRateControl();

        $this->addInitialMonthsControl();

        $this->addInitialDownPaymentControl();

        $this->addDynamicDownPaymentControls();

        $this->addCustomRulesControl();

        $this->addShowLogicControl();

        $this->endControlsSection();
    }

    public function getInitialMonths(Model $model = null): int
    {
        $initialMonths = (int)$this->get_settings_for_display(self::MONTHS);
        if ($model === null) {
            return $initialMonths;
        }
        foreach ($this->getCustomRules() as $customRule) {
            if (empty($customRule['taxonomy'])) {
                continue;
            }
            $termId = (int)$customRule[$customRule['taxonomy'] . '_term'];
            if (empty($termId)) {
                continue;
            }
            if (has_term($termId, $customRule['taxonomy'], $model->getId())) {
                return $customRule[self::MONTHS];
            }
        }
        return $initialMonths;
    }

    protected function addCustomRulesControl(): void
    {
        $controls = new Repeater();
        $taxonomies = [];

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $taxonomies[$taxonomyField->getKey()] = $taxonomyField->getName();
        }

        $controls->add_control(
            'taxonomy',
            [
                'label' => tdf_admin_string('taxonomy'),
                'type' => Controls_Manager::SELECT,
                'options' => $taxonomies,
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $controls->add_control(
                $taxonomyField->getKey() . '_term',
                [
                    'label' => tdf_admin_string('term'),
                    'type' => SelectRemoteControl::TYPE,
                    'source' => $taxonomyField->getApiEndpoint(),
                    'condition' => [
                        'taxonomy' => $taxonomyField->getKey(),
                    ]
                ]
            );
        }

        $controls->add_control(
            self::RATE,
            [
                'label' => tdf_admin_string('initial_rate'),
                'type' => Controls_Manager::TEXT,
                'default' => 5
            ]
        );

        $controls->add_control(
            self::MONTHS,
            [
                'label' => tdf_admin_string('initial_months'),
                'type' => Controls_Manager::TEXT,
                'default' => 36,
            ]
        );

        $this->add_control(
            'custom_rules',
            [
                'label' => tdf_admin_string('custom_rules'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $controls->get_controls(),
            ]
        );
    }

    protected function getCustomRules(): Collection
    {
        $customRules = $this->get_settings_for_display('custom_rules');
        if (empty($customRules)) {
            return tdf_collect();
        }

        return tdf_collect($customRules);
    }

    protected function addInitialPriceControl(): void
    {
        $this->add_control(
            self::PRICE,
            [
                'label' => tdf_admin_string('initial_price'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );
    }

    protected function addInitialRateControl(): void
    {
        $this->add_control(
            self::RATE,
            [
                'label' => tdf_admin_string('initial_rate'),
                'type' => Controls_Manager::TEXT,
                'default' => 5
            ]
        );
    }

    protected function addInitialMonthsControl(): void
    {
        $this->add_control(
            self::MONTHS,
            [
                'label' => tdf_admin_string('initial_months'),
                'type' => Controls_Manager::TEXT,
                'default' => 36,
            ]
        );
    }

    protected function addInitialDownPaymentControl(): void
    {
        $this->add_control(
            self::DOWN_PAYMENT,
            [
                'label' => tdf_admin_string('initial_down_payment'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );
    }

    protected function addDynamicDownPaymentControls(): void
    {
        $this->add_control(
            self::DYNAMIC_DOWN_PAYMENT,
            [
                'label' => tdf_admin_string('dynamic_down_payment'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            self::DYNAMIC_DOWN_PAYMENT_PERCENTAGE,
            [
                'label' => tdf_admin_string('price_percentage'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                    'size' => 20,
                ],
                'size_units' => ['%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'condition' => [
                    self::DYNAMIC_DOWN_PAYMENT => '1'
                ]
            ]
        );
    }

    /**
     * @return float|int|string
     */
    public function getInitialPrice()
    {
        return $this->get_settings_for_display(self::PRICE);
    }

    /**
     * @param Model|null $model
     * @return int
     */
    public function getInitialRate(Model $model = null): int
    {
        $initialRate = (int)$this->get_settings_for_display(self::RATE);

        if ($model === null) {
            return $initialRate;
        }

        foreach ($this->getCustomRules() as $customRule) {
            if (empty($customRule['taxonomy'])) {
                continue;
            }

            $termId = (int)$customRule[$customRule['taxonomy'] . '_term'];
            if (empty($termId)) {
                continue;
            }

            if (has_term($termId, $customRule['taxonomy'], $model->getId())) {
                return $customRule[self::RATE];
            }
        }

        return $initialRate;
    }

    public function getDownPayment(): int
    {
        return (int)$this->get_settings_for_display(self::DOWN_PAYMENT);
    }

    protected function isDynamicDownPaymentEnabled(): bool
    {
        return !empty($this->get_settings_for_display(self::DYNAMIC_DOWN_PAYMENT));
    }

    protected function getDynamicDownPaymentValue(): float
    {
        $value = $this->get_settings_for_display(self::DYNAMIC_DOWN_PAYMENT_PERCENTAGE);

        return ((int)$value['size'] / 100);
    }

    protected function addShowLogicControl(): void
    {
        $fields = new Repeater();

        $fields->add_control(
            'taxonomy',
            [
                'label' => tdf_admin_string('taxonomy'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('taxonomy_list')
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomy) {
            $fields->add_control(
                'taxonomy_' . $taxonomy->getKey(),
                [
                    'label' => tdf_admin_string('terms'),
                    'type' => SelectRemoteControl::TYPE,
                    'multiple' => true,
                    'source' => $taxonomy->getApiEndpoint(),
                    'condition' => [
                        'taxonomy' => $taxonomy->getKey(),
                    ]
                ]
            );
        }

        $this->add_control(
            'show_logic',
            [
                'label' => tdf_admin_string('show_only_for_the_terms'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    public function display(Model $model): bool
    {
        $taxonomies = $this->get_settings_for_display('show_logic');
        if (empty($taxonomies)) {
            return true;
        }

        foreach ($taxonomies as $taxonomy) {
            $key = $taxonomy['taxonomy'];
            $termIds = $taxonomy['taxonomy_' . $key];

            if (!is_array($termIds)) {
                continue;
            }

            foreach ($termIds as $termId) {
                if ($model->hasTerm($key, (int)$termId)) {
                    return true;
                }
            }
        }

        return false;
    }
}