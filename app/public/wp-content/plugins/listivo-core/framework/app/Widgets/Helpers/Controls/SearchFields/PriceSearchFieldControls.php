<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Search\Field\PriceSearchField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

/**
 * Trait PriceSearchFieldControls
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields
 */
trait PriceSearchFieldControls
{
    use Control;

    /**
     * @param Repeater $fields
     * @param bool $sidebar
     * @return void
     */
    protected function addPriceFieldSettings(Repeater $fields, bool $sidebar = false): void
    {
        $priceFieldKeys = $this->getPriceFieldKeys();

        $options = [
            PriceSearchField::CONTROL_TEXT_INPUT_RANGE => tdf_admin_string('text_input_range'),
            PriceSearchField::CONTROL_SELECT => tdf_admin_string('select'),
            PriceSearchField::CONTROL_SELECT_RANGE => tdf_admin_string('select_range'),
        ];

        if ($sidebar) {
            $options[PriceSearchField::CONTROL_RADIO] = tdf_admin_string('radio');
        }

        $fields->add_control(
            PriceSearchField::CONTROL,
            [
                'label' => tdf_admin_string('control'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => PriceSearchField::CONTROL_TEXT_INPUT_RANGE,
                'condition' => [
                    'field' => $priceFieldKeys,
                ]
            ]
        );

        $fields->add_control(
            PriceSearchField::COMPARE_TYPE,
            [
                'label' => tdf_admin_string('compare_type'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    PriceSearchField::COMPARE_TYPE_GREATER => tdf_admin_string('greater_than'),
                    PriceSearchField::COMPARE_TYPE_LESS => tdf_admin_string('less_than'),
                ],
                'default' => PriceSearchField::COMPARE_TYPE_GREATER,
                'condition' => [
                    'field' => $priceFieldKeys,
                    'price_control' => [
                        PriceSearchField::CONTROL_SELECT,
                        PriceSearchField::CONTROL_RADIO,
                    ]
                ]
            ]
        );


        $fields->add_control(
            PriceSearchField::PLACEHOLDER,
            [
                'label' => tdf_admin_string('placeholder'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'field' => $priceFieldKeys,
                    'price_control' => [
                        PriceSearchField::CONTROL_SELECT,
                    ]
                ]
            ]
        );

        $fields->add_control(
            PriceSearchField::PLACEHOLDER_FROM,
            [
                'label' => tdf_admin_string('placeholder_from'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'field' => $priceFieldKeys,
                    'price_control' => [
                        PriceSearchField::CONTROL_SELECT_RANGE,
                        PriceSearchField::CONTROL_TEXT_INPUT_RANGE
                    ]
                ]
            ]
        );

        $fields->add_control(
            PriceSearchField::PLACEHOLDER_TO,
            [
                'label' => tdf_admin_string('placeholder_to'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'field' => $priceFieldKeys,
                    'price_control' => [
                        PriceSearchField::CONTROL_SELECT_RANGE,
                        PriceSearchField::CONTROL_TEXT_INPUT_RANGE
                    ]]
            ]
        );

        foreach (tdf_currencies() as $currency) {
            $fields->add_control(
                PriceSearchField::PRICE_VALUES . $currency->getKey(),
                [
                    'label' => tdf_admin_string('values') . ' (' . $currency->getSign() . ')',
                    'type' => Controls_Manager::TEXT,
                    'condition' => [
                        'field' => $priceFieldKeys,
                        'price_control' => [
                            PriceSearchField::CONTROL_SELECT,
                            PriceSearchField::CONTROL_RADIO,
                        ],
                    ]
                ]
            );

            $fields->add_control(
                PriceSearchField::PRICE_VALUES_FROM . $currency->getKey(),
                [
                    'label' => tdf_admin_string('values_from') . ' (' . $currency->getSign() . ')',
                    'type' => Controls_Manager::TEXT,
                    'condition' => [
                        'field' => $priceFieldKeys,
                        'price_control' => PriceSearchField::CONTROL_SELECT_RANGE,
                    ]
                ]
            );

            $fields->add_control(
                PriceSearchField::PRICE_VALUES_TO . $currency->getKey(),
                [
                    'label' => tdf_admin_string('values_to') . ' (' . $currency->getSign() . ')',
                    'type' => Controls_Manager::TEXT,
                    'condition' => [
                        'field' => $priceFieldKeys,
                        'price_control' => PriceSearchField::CONTROL_SELECT_RANGE,
                    ]
                ]
            );
        }
    }

    /**
     * @return array
     */
    private function getPriceFieldKeys(): array
    {
        return tdf_fields()
            ->filter(static function ($field) {
                return $field instanceof PriceField || $field instanceof SalaryField;
            })->map(static function ($field) {
                /* @var PriceField $field */
                return $field->getKey();
            })
            ->values();
    }

}