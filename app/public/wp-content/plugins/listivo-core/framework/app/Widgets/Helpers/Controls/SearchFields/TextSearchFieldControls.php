<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Search\Field\TextSearchField;
use Tangibledesign\Framework\Models\Field\TextField;

/**
 * Trait TextSearchFieldControls
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields
 */
trait TextSearchFieldControls
{
    /**
     * @param Repeater $fields
     */
    protected function addTextFieldSettings(Repeater $fields): void
    {
        $fields->add_control(
            TextSearchField::PLACEHOLDER,
            [
                'label' => tdf_admin_string('placeholder'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'field' => $this->getTextFieldKeys(),
                ]
            ]
        );
    }

    /**
     * @return array
     */
    private function getTextFieldKeys(): array
    {
        return tdf_fields()
            ->filter(static function ($field) {
                return $field instanceof TextField;
            })
            ->map(static function ($field) {
                /* @var TextField $field */
                return $field->getKey();
            })
            ->values();
    }

}