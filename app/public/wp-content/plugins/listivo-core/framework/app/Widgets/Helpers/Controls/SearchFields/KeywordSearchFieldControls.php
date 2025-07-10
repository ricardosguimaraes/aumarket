<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Search\Field\KeywordSearchField;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

/**
 * Trait KeywordSearchFieldControls
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields
 */
trait KeywordSearchFieldControls
{
    use Control;

    /**
     * @param Repeater $fields
     */
    protected function addKeywordFieldSettings(Repeater $fields): void
    {
        $fields->add_control(
            KeywordSearchField::PLACEHOLDER,
            [
                'label' => tdf_admin_string('placeholder'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
                'condition' => [
                    'field' => 'keyword',
                ]
            ]
        );

        $fields->add_control(
            KeywordSearchField::MIN_CHARACTERS,
            [
                'label' => tdf_admin_string('keyword_min_characters_description'),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'default' => 1,
                'condition' => [
                    'field' => 'keyword',
                ]
            ]
        );

        $fields->add_control(
            KeywordSearchField::KEYWORD_SUGGESTION_LIMIT,
            [
                'label' => tdf_admin_string('keyword_suggestion_limit'),
                'label_block' => true,
                'type' => Controls_Manager::NUMBER,
                'default' => 10,
                'condition' => [
                    'field' => 'keyword',
                ]
            ]
        );

        $fields->add_control(
            KeywordSearchField::TAXONOMIES,
            [
                'label' => tdf_admin_string('taxonomies'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $this->getTaxonomyOptions(),
                'condition' => [
                    'field' => 'keyword',
                ]
            ]
        );
    }

    /**
     * @return array
     */
    private function getTaxonomyOptions(): array
    {
        $options = [];

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $options[$taxonomyField->getKey()] = $taxonomyField->getName();
        }

        return $options;
    }

}