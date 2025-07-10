<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Search\Field\TaxonomySearchField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

trait TaxonomySearchFieldControls
{
    protected function addTaxonomyFieldSettings(Repeater $fields, bool $sidebar = false): void
    {
        $taxonomyFieldKeys = $this->getTaxonomyFieldKeys();
        $notMultilevelTaxonomyFieldKeys = $this->getNotMultilevelTaxonomyFieldKeys();
        $multilevelTaxonomyFieldKeys = $this->getMultilevelTaxonomyFieldKeys();
        $taxonomyWithParentsKeys = $this->getTaxonomyWithParentsKeys();

        $options = [
            TaxonomySearchField::CONTROL_SELECT => tdf_admin_string('select'),
            TaxonomySearchField::CONTROL_SELECT_MULTIPLE => tdf_admin_string('select_multiple'),
        ];

        if ($sidebar) {
            $options[TaxonomySearchField::CONTROL_CHECKBOX] = tdf_admin_string('checkbox');
            $options[TaxonomySearchField::CONTROL_RADIO] = tdf_admin_string('radio');
        }

        $fields->add_control(
            TaxonomySearchField::CONTROL,
            [
                'label' => tdf_admin_string('control'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => TaxonomySearchField::CONTROL_SELECT,
                'condition' => [
                    'field' => $notMultilevelTaxonomyFieldKeys,
                ]
            ]
        );

        if ($sidebar) {
            $fields->add_control(
                TaxonomySearchField::MULTILEVEL_CONTROL,
                [
                    'label' => tdf_admin_string('control'),
                    'type' => Controls_Manager::SELECT,
                    'options' => [
                        TaxonomySearchField::CONTROL_SELECT => tdf_admin_string('select'),
                        TaxonomySearchField::CONTROL_RADIO => tdf_admin_string('radio'),
                    ],
                    'default' => TaxonomySearchField::CONTROL_SELECT,
                    'condition' => [
                        'field' => $multilevelTaxonomyFieldKeys,
                    ]
                ]
            );

            $fields->add_control(
                TaxonomySearchField::ALL_LABEL,
                [
                    'label' => tdf_admin_string('all_label'),
                    'type' => Controls_Manager::TEXT,
                    'placeholder' => tdf_string('all'),
                    'condition' => [
                        TaxonomySearchField::MULTILEVEL_CONTROL => TaxonomySearchField::CONTROL_RADIO,
                        'field' => $multilevelTaxonomyFieldKeys,
                    ]
                ]
            );

            $fields->add_control(
                TaxonomySearchField::LIMIT_HEIGHT,
                [
                    'label' => tdf_admin_string('limit_option_list_height'),
                    'label_block' => true,
                    'type' => Controls_Manager::SWITCHER,
                    'return_value' => '1',
                    'default' => '0',
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'field',
                                'operator' => 'in',
                                'value' => $taxonomyFieldKeys,
                            ],
                            [
                                'relation' => 'or',
                                'terms' => [
                                    [
                                        'name' => TaxonomySearchField::CONTROL,
                                        'operator' => 'in',
                                        'value' => [TaxonomySearchField::CONTROL_RADIO, TaxonomySearchField::CONTROL_CHECKBOX],
                                    ],
                                    [
                                        'name' => TaxonomySearchField::MULTILEVEL_CONTROL,
                                        'operator' => '===',
                                        'value' => TaxonomySearchField::CONTROL_RADIO,
                                    ],
                                ],
                            ]
                        ],
                    ]
                ]
            );

            $fields->add_responsive_control(
                'taxonomy_max_height',
                [
                    'label' => tdf_admin_string('max_height_px'),
                    'type' => Controls_Manager::NUMBER,
                    'placeholder' => 165,
                    'selectors' => [
                        '{{WRAPPER}} {{CURRENT_ITEM}} .' . tdf_prefix() . '-search-panel__list' => 'max-height: {{VALUE}}px;',
                    ],
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'field',
                                'operator' => 'in',
                                'value' => $taxonomyFieldKeys,
                            ],
                            [
                                'name' => TaxonomySearchField::LIMIT_HEIGHT,
                                'value' => '1',
                            ],
                            [
                                'relation' => 'or',
                                'terms' => [
                                    [
                                        'name' => TaxonomySearchField::CONTROL,
                                        'operator' => 'in',
                                        'value' => [TaxonomySearchField::CONTROL_RADIO, TaxonomySearchField::CONTROL_CHECKBOX],
                                    ],
                                    [
                                        'name' => TaxonomySearchField::MULTILEVEL_CONTROL,
                                        'operator' => '===',
                                        'value' => TaxonomySearchField::CONTROL_RADIO,
                                    ],
                                ],
                            ]
                        ],
                    ]
                ]
            );

            $fields->add_control(
                TaxonomySearchField::OPTION_LIMIT,
                [
                    'label' => tdf_admin_string('options_limit'),
                    'type' => Controls_Manager::NUMBER,
                    'default' => 6,
                    'conditions' => [
                        'relation' => 'and',
                        'terms' => [
                            [
                                'name' => 'field',
                                'operator' => 'in',
                                'value' => $taxonomyFieldKeys,
                            ],
                            [
                                'relation' => 'or',
                                'terms' => [
                                    [
                                        'name' => TaxonomySearchField::CONTROL,
                                        'operator' => 'in',
                                        'value' => [TaxonomySearchField::CONTROL_RADIO, TaxonomySearchField::CONTROL_CHECKBOX],
                                    ],
                                    [
                                        'name' => TaxonomySearchField::MULTILEVEL_CONTROL,
                                        'operator' => '===',
                                        'value' => TaxonomySearchField::CONTROL_RADIO,
                                    ],
                                ],
                            ]
                        ],
                    ]
                ]
            );
        }

        $fields->add_control(
            TaxonomySearchField::SHOW_CHILDREN,
            [
                'label' => tdf_admin_string('display_subcategory_controls'),
                'type' => Controls_Manager::SWITCHER,
                'label_block' => true,
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'field' => $multilevelTaxonomyFieldKeys,
                ]
            ]
        );

        $fields->add_control(
            TaxonomySearchField::PLACEHOLDER,
            [
                'label' => tdf_admin_string('placeholder'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'field' => $taxonomyFieldKeys,
                    TaxonomySearchField::CONTROL => [
                        TaxonomySearchField::CONTROL_SELECT,
                        TaxonomySearchField::CONTROL_SELECT_MULTIPLE,
                    ]
                ]
            ]
        );

        $fields->add_control(
            TaxonomySearchField::SEARCHABLE,
            [
                'label' => tdf_admin_string('searchable'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'field' => $taxonomyFieldKeys,
                ]
            ]
        );

        $fields->add_control(
            TaxonomySearchField::TERM_COUNT,
            [
                'label' => tdf_admin_string('term_count'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'field' => $taxonomyFieldKeys,
                ]
            ]
        );

        $fields->add_control(
            TaxonomySearchField::TERM_NO_RESULTS,
            [
                'label' => tdf_admin_string('term_no_results'),
                'label_block' => true,
                'type' => Controls_Manager::SELECT,
                'options' => [
                    TaxonomySearchField::TERM_NO_RESULTS_DISABLE => tdf_admin_string('disable'),
                    TaxonomySearchField::TERM_NO_RESULTS_HIDE => tdf_admin_string('hide'),
                ],
                'default' => TaxonomySearchField::TERM_NO_RESULTS_DISABLE,
                'condition' => [
                    'field' => $taxonomyFieldKeys,
                ]
            ]
        );

        $fields->add_control(
            TaxonomySearchField::DISABLE_UNTIL_PARENT_SELECTED,
            [
                'label' => tdf_admin_string('disable_until_parent_selected'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
                'condition' => [
                    'field' => $taxonomyWithParentsKeys,
                ]
            ]
        );

        $fields->add_control(
            TaxonomySearchField::TERMS_ORDER,
            [
                'label' => tdf_admin_string('terms_order'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    TaxonomySearchField::TERMS_ORDER_NAME => tdf_admin_string('name'),
                    TaxonomySearchField::TERMS_ORDER_COUNT => tdf_admin_string('count'),
                    TaxonomySearchField::TERMS_ORDER_CUSTOM => tdf_admin_string('custom'),

                ],
                'default' => TaxonomySearchField::TERMS_ORDER_NAME,
                'condition' => [
                    'field' => $taxonomyFieldKeys,
                ]
            ]
        );

        $fields->add_control(
            TaxonomySearchField::CUSTOM_ORDER,
            [
                'label' => tdf_admin_string('custom_order'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => '32,45,39',
                'condition' => [
                    'field' => $taxonomyFieldKeys,
                    TaxonomySearchField::TERMS_ORDER => TaxonomySearchField::TERMS_ORDER_CUSTOM,
                ]
            ]
        );
    }

    private function getTaxonomyWithParentsKeys(): array
    {
        return tdf_taxonomy_fields()->filter(static function ($taxonomy) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getParentTaxonomyFields()->isNotEmpty();
        })->map(static function ($taxonomy) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getKey();
        })->values();
    }

    private function getTaxonomyFieldKeys(): array
    {
        return tdf_taxonomy_fields()->map(static function ($taxonomyField) {
            /* @var TaxonomyField $taxonomyField */
            return $taxonomyField->getKey();
        })->values();
    }

    private function getNotMultilevelTaxonomyFieldKeys(): array
    {
        return tdf_taxonomy_fields()->filter(static function ($taxonomyField) {
            /* @var TaxonomyField $taxonomyField */
            return !$taxonomyField->isMultilevel();
        })->map(static function ($taxonomyField) {
            /* @var TaxonomyField $taxonomyField */
            return $taxonomyField->getKey();
        })->values();
    }

    private function getMultilevelTaxonomyFieldKeys(): array
    {
        return tdf_taxonomy_fields()->filter(static function ($taxonomyField) {
            /* @var TaxonomyField $taxonomyField */
            return $taxonomyField->isMultilevel();
        })->map(static function ($taxonomyField) {
            /* @var TaxonomyField $taxonomyField */
            return $taxonomyField->getKey();
        })->values();
    }
}