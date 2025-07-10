<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Search\Field\NumberSearchField;
use Tangibledesign\Framework\Models\Field\NumberField;

/**
 * Trait NumberSearchFieldControls
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields
 */
trait NumberSearchFieldControls
{
    /**
     * @param Repeater $fields
     * @param bool $sidebar
     * @return void
     */
    protected function addNumberFieldSettings(Repeater $fields, bool $sidebar = false): void
    {
        $numberFieldKeys = $this->getNumberFieldKeys();

        $options = [
            NumberSearchField::CONTROL_TEXT_INPUT_RANGE => tdf_admin_string('text_input_range'),
            NumberSearchField::CONTROL_SELECT => tdf_admin_string('select'),
        ];

        if ($sidebar) {
            $options[NumberSearchField::CONTROL_RADIO] = tdf_admin_string('radio');
        }

        $fields->add_control(
            NumberSearchField::CONTROL,
            [
                'label' => tdf_admin_string('control'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => NumberSearchField::CONTROL_TEXT_INPUT_RANGE,
                'condition' => [
                    'field' => $numberFieldKeys,
                ]
            ]
        );

        $fields->add_control(
            NumberSearchField::PLACEHOLDER,
            [
                'label' => tdf_admin_string('placeholder'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'field' => $numberFieldKeys,
                    'number_control' => [
                        NumberSearchField::CONTROL_SELECT,
                    ],
                ]
            ]
        );

        $fields->add_control(
            NumberSearchField::PLACEHOLDER_FROM,
            [
                'label' => tdf_admin_string('placeholder_from'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'field' => $numberFieldKeys,
                    'number_control' => NumberSearchField::CONTROL_TEXT_INPUT_RANGE
                ]
            ]
        );

        $fields->add_control(
            NumberSearchField::PLACEHOLDER_TO,
            [
                'label' => tdf_admin_string('placeholder_to'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'field' => $numberFieldKeys,
                    'number_control' => NumberSearchField::CONTROL_TEXT_INPUT_RANGE
                ]
            ]
        );

        $fields->add_control(
            NumberSearchField::COMPARE_TYPE,
            [
                'label' => tdf_admin_string('compare_type'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    NumberSearchField::COMPARE_TYPE_GREATER => tdf_admin_string('greater_than'),
                    NumberSearchField::COMPARE_TYPE_LESS => tdf_admin_string('less_than'),
                    NumberSearchField::COMPARE_TYPE_EQUAL => tdf_admin_string('equal'),
                ],
                'default' => NumberSearchField::COMPARE_TYPE_GREATER,
                'condition' => [
                    'field' => $numberFieldKeys,
                    'number_control' => [
                        NumberSearchField::CONTROL_SELECT,
                        NumberSearchField::CONTROL_RADIO
                    ],
                ]
            ]
        );

        $fields->add_control(
            NumberSearchField::VALUES,
            [
                'label' => tdf_admin_string('values'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '1000,2000,3000',
                'description' => tdf_admin_string('number_values'),
                'condition' => [
                    'field' => $numberFieldKeys,
                    'number_control' => [
                        NumberSearchField::CONTROL_SELECT,
                        NumberSearchField::CONTROL_RADIO
                    ],]
            ]
        );

        $fields->add_control(
            NumberSearchField::ADD_GREATER_THAN_VALUE,
            [
                'label' => tdf_admin_string('add_greater_than_value'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
                'conditions' => [
                    'terms' => [
                        [
                            'name' => 'field',
                            'operator' => 'in',
                            'value' => $numberFieldKeys
                        ],
                        [
                            'relation' => 'or',
                            'terms' => [
                                [
                                    'terms' => [
                                        [
                                            'name' => NumberSearchField::CONTROL,
                                            'operator' => 'in',
                                            'value' => [
                                                NumberSearchField::CONTROL_SELECT,
                                                NumberSearchField::CONTROL_RADIO
                                            ]
                                        ],
                                        [
                                            'name' => NumberSearchField::COMPARE_TYPE,
                                            'operator' => '=',
                                            'value' => NumberSearchField::COMPARE_TYPE_LESS
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ],
                ]
            ]
        );
    }

    /**
     * @return array
     */
    private function getNumberFieldKeys(): array
    {
        return tdf_fields()
            ->filter(static function ($field) {
                return $field instanceof NumberField;
            })->map(static function ($field) {
                /* @var NumberField $field */
                return $field->getKey();
            })->values();
    }

}