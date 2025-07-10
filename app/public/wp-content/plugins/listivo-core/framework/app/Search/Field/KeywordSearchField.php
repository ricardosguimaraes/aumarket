<?php


namespace Tangibledesign\Framework\Search\Field;


use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Search\SearchField;

/**
 * Class KeywordSearchField
 * @package Tangibledesign\Framework\Search\Field
 */
class KeywordSearchField extends SearchField
{
    public const PLACEHOLDER = 'keyword_placeholder';
    public const MIN_CHARACTERS = 'keyword_min_characters';
    public const TAXONOMIES = 'keyword_taxonomies';
    public const KEYWORD_SUGGESTION_LIMIT = 'keyword_suggestion_limit';

    /**
     * @var array
     */
    protected $config;

    /**
     * KeywordSearchField constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_string('keyword');
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'keyword';
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return 'keyword';
    }

    /**
     * @return string
     */
    public function getPlaceholder(): string
    {
        $placeholder = $this->config[self::PLACEHOLDER] ?? '';

        if (empty($placeholder)) {
            return tdf_admin_string('keyword');
        }

        return $placeholder;
    }

    /**
     * @return int
     */
    public function getMinCharacters(): int
    {
        return (int)($this->config[self::MIN_CHARACTERS] ?? 1);
    }

    /**
     * @return string[]
     */
    public function getTaxonomyKeys(): array
    {
        $taxonomyKeys = $this->config[self::TAXONOMIES] ?? [];

        if (!is_array($taxonomyKeys) || empty($taxonomyKeys)) {
            return tdf_taxonomy_fields()->map(static function ($taxonomyField) {
                /* @var TaxonomyField */
                return $taxonomyField->getKey();
            })->values();
        }

        return $taxonomyKeys;
    }

    /**
     * @return int
     */
    public function getKeywordSuggestionLimit(): int
    {
        return (int)($this->config[self::KEYWORD_SUGGESTION_LIMIT] ?? 7);
    }

}