<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Search\Field\LocationSearchField;
use Tangibledesign\Framework\Models\Field\LocationField;

/**
 * Trait LocationSearchFieldControls
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields
 */
trait LocationSearchFieldControls
{
    /**
     * @param Repeater $fields
     * @param bool $showRadiusField
     */
    protected function addLocationFieldSettings(Repeater $fields, bool $showRadiusField = true): void
    {
        $locationFieldKeys = $this->getLocationFieldKeys();

        $fields->add_control(
            LocationSearchField::PLACEHOLDER,
            [
                'label' => tdf_admin_string('placeholder'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'field' => $locationFieldKeys
                ]
            ]
        );

        $fields->add_control(
            LocationSearchField::ASK_FOR_LOCATION,
            [
                'label' => tdf_admin_string('ask_for_location'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
                'condition' => [
                    'field' => $locationFieldKeys
                ]
            ]
        );

        $fields->add_control(
            LocationSearchField::SHOW_MY_LOCATION_BUTTON,
            [
                'label' => tdf_admin_string('display_my_location_button'),
                'label_block' => true,
                'type' => Controls_Manager::SWITCHER,
                'default' => '1',
                'return_value' => '1',
                'condition' => [
                    'field' => $locationFieldKeys
                ]
            ]
        );

        if ($showRadiusField) {
            $this->addRadiusControls($fields, $locationFieldKeys);
        } else {
            $fields->add_control(
                LocationSearchField::SHOW_RADIUS,
                [
                    'type' => Controls_Manager::HIDDEN,
                    'default' => '0',
                    'return_value' => '0',
                    'condition' => [
                        'field' => $locationFieldKeys
                    ]
                ]
            );
        }
    }

    /**
     * @param Repeater $fields
     * @param array $locationFieldKeys
     */
    private function addRadiusControls(Repeater $fields, array $locationFieldKeys): void
    {
        $fields->add_control(
            LocationSearchField::SHOW_RADIUS,
            [
                'label' => tdf_admin_string('display_radius_control'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '0',
                'return_value' => '1',
                'condition' => [
                    'field' => $locationFieldKeys
                ]
            ]
        );

        $fields->add_control(
            LocationSearchField::RADIUS_PLACEHOLDER,
            [
                'label' => tdf_admin_string('radius_placeholder'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'field' => $locationFieldKeys,
                    LocationSearchField::SHOW_RADIUS => '1'
                ]
            ]
        );

        $fields->add_control(
            LocationSearchField::RADIUS_VALUES,
            [
                'label' => tdf_admin_string('radius_values'),
                'type' => Controls_Manager::TEXT,
                'default' => '10,20,30,50,75,100,200,500',
                'condition' => [
                    'field' => $locationFieldKeys,
                    LocationSearchField::SHOW_RADIUS => '1'
                ]
            ]
        );

        $fields->add_control(
            LocationSearchField::DEFAULT_RADIUS,
            [
                'label' => tdf_admin_string('initial_radius_value'),
                'type' => Controls_Manager::TEXT,
                'default' => '30',
                'description' => tdf_admin_string('initial_radius_value_description'),
                'condition' => [
                    'field' => $locationFieldKeys,
                    LocationSearchField::SHOW_RADIUS => '1'
                ]
            ]
        );
    }

    /**
     * @return array
     */
    private function getLocationFieldKeys(): array
    {
        return tdf_fields()
            ->filter(static function ($field) {
                return $field instanceof LocationField;
            })
            ->map(static function ($field) {
                /* @var LocationField $field */
                return $field->getKey();
            })
            ->values();
    }

}