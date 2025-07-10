<?php

namespace Tangibledesign\Framework\Search\Field;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

class TaxonomySearchField extends BaseSearchField
{
    public const CONTROL = 'taxonomy_control';
    public const MULTILEVEL_CONTROL = 'taxonomy_multilevel_control';
    public const CONTROL_SELECT = 'select';
    public const CONTROL_SELECT_MULTIPLE = 'select_multiple';
    public const CONTROL_RADIO = 'radio';
    public const CONTROL_CHECKBOX = 'checkbox';
    public const PLACEHOLDER = 'taxonomy_placeholder';
    public const SEARCHABLE = 'taxonomy_searchable';
    public const TERM_COUNT = 'taxonomy_term_count';
    public const TERM_NO_RESULTS = 'taxonomy_term_no_results';
    public const TERM_NO_RESULTS_DISABLE = 'disable';
    public const TERM_NO_RESULTS_HIDE = 'hide';
    public const DISABLE_UNTIL_PARENT_SELECTED = 'taxonomy_disable_until_parent_selected';
    public const TERMS_ORDER = 'taxonomy_terms_order';
    public const TERMS_ORDER_NAME = 'name';
    public const TERMS_ORDER_COUNT = 'count';
    public const TERMS_ORDER_CUSTOM = 'custom';
    public const CUSTOM_ORDER = 'taxonomy_custom_order';
    public const SHOW_CHILDREN = 'show_children';
    public const OPTION_LIMIT = 'taxonomy_option_limit';
    public const ALL_LABEL = 'taxonomy_all_label';
    public const LIMIT_HEIGHT = 'taxonomy_limit_height';

    protected $field;

    protected $config;

    public function __construct(TaxonomyField $field, array $config)
    {
        $this->field = $field;

        $this->config = $config;
    }

    public function getRepeaterFieldId(): string
    {
        return $this->config['_id'];
    }

    public function getControl(): string
    {
        if ($this->field->isMultilevel()) {
            return $this->config[self::MULTILEVEL_CONTROL] ?? self::CONTROL_SELECT;
        }

        return $this->config[self::CONTROL] ?? self::CONTROL_SELECT;
    }

    public function isSelectControl(): bool
    {
        return $this->getControl() === self::CONTROL_SELECT;
    }

    public function isSelectMultipleControl(): bool
    {
        return $this->getControl() === self::CONTROL_SELECT_MULTIPLE || $this->getControl() === self::CONTROL_CHECKBOX;
    }

    public function isRadioControl(): bool
    {
        return $this->getControl() === self::CONTROL_RADIO;
    }

    public function isCheckboxControl(): bool
    {
        return $this->getControl() === self::CONTROL_CHECKBOX;
    }

    public function getPlaceholder(): string
    {
        $placeholder = $this->config[self::PLACEHOLDER] ?? '';

        if (empty($placeholder)) {
            return $this->field->getName();
        }

        return $placeholder;
    }

    public function searchable(): bool
    {
        return !empty($this->config[self::SEARCHABLE]);
    }

    public function showTermCount(): bool
    {
        return !empty($this->config[self::TERM_COUNT]);
    }

    public function whenTermHasNoResults(): string
    {
        return $this->config[self::TERM_NO_RESULTS] ?? 'disable';
    }

    public function disableUntilParentSelected(): bool
    {
        return !empty($this->config[self::DISABLE_UNTIL_PARENT_SELECTED]);
    }

    public function getOrderType(): string
    {
        return $this->config[self::TERMS_ORDER] ?? 'name';
    }

    public function getCustomOrderTerms(): Collection
    {
        $termIds = explode(',', $this->config[self::CUSTOM_ORDER]);
        if (empty($termIds)) {
            return tdf_collect();
        }

        $termIds = tdf_collect($termIds)->map(static function ($termId) {
            return (int)trim($termId);
        })->values();

        return tdf_query_terms($this->field->getKey())
            ->in($termIds)
            ->orderByIn()
            ->get();
    }

    public function getTerms(): Collection
    {
        if (function_exists('customtaxorder_sort_taxonomies')) {
            return tdf_query_terms($this->field->getKey())
                ->orderBy3rdPartyPlugin()
                ->get();
        }

        if ($this->getOrderType() === self::TERMS_ORDER_CUSTOM) {
            return $this->getCustomOrderTerms();
        }

        return $this->field->getTerms();
    }

    public function getMainTerms(): Collection
    {
        if (function_exists('customtaxorder_sort_taxonomies')) {
            return tdf_query_terms($this->field->getKey())
                ->orderBy3rdPartyPlugin()
                ->get();
        }

        if ($this->getOrderType() === self::TERMS_ORDER_CUSTOM) {
            return $this->getCustomOrderTerms();
        }

        return $this->field->getMainTerms();
    }

    public function isCustomOrder():bool
    {
        return $this->getOrderType() === self::TERMS_ORDER_CUSTOM;
    }

    public function jsonSerialize(): array
    {
        return parent::jsonSerialize() + [
                'multiple' => $this->field->multipleValues(),
                'multilevel' => $this->field->isMultilevel(),
                'orderType' => $this->getOrderType(),
                'whenTermHasNoResults' => $this->whenTermHasNoResults(),
                'disableUntilParentSelected' => $this->disableUntilParentSelected(),
                'parentTaxonomyKeys' => $this->field->getParentTaxonomyFields()->map(static function ($taxonomyField) {
                    /* @var TaxonomyField $taxonomyField */
                    return $taxonomyField->getKey();
                })->values(),
            ];
    }

    public function showChildren(): bool
    {
        return !empty($this->config[self::SHOW_CHILDREN]);
    }

    public function getOptionsLimit(): int
    {
        return (int)($this->config[self::OPTION_LIMIT] ?? 0);
    }

    public function isMultilevel(): bool
    {
        return $this->field->isMultilevel();
    }

    public function getAllLabel(): string
    {
        if (empty($this->config[self::ALL_LABEL])) {
            return tdf_string('all');
        }

        return $this->config[self::ALL_LABEL];
    }

    public function limitHeight(): bool
    {
        return !empty((int)($this->config[self::LIMIT_HEIGHT] ?? 0));
    }

    public function disableLazyLoadTerms(): bool
    {
        if ($this->field->isTermsLazyLoadingDisabled()) {
            return true;
        }

        if ($this->field->getParentTaxonomyFields()->isEmpty()) {
            return true;
        }

        if (!$this->disableUntilParentSelected()) {
            return true;
        }

        if (!$this->isSelectControl() && !$this->isSelectMultipleControl()) {
            return true;
        }

        if ($this->isCheckboxControl()) {
            return true;
        }

        if ($this->isMultilevel()) {
            return true;
        }

        return false;
    }
}