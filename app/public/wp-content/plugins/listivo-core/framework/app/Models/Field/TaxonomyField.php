<?php

namespace Tangibledesign\Framework\Models\Field;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Search\Field\TaxonomySearchField;
use Tangibledesign\Framework\Search\HasQueryModifier;
use Tangibledesign\Framework\Search\Query\TaxonomyQueryModifier;
use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;
use Tangibledesign\Framework\Search\Searchable;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Models\Term\Term;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholder;
use Tangibledesign\Framework\Models\Field\Helpers\HasInputPlaceholderInterface;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlug;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlugInterface;

class TaxonomyField extends Field implements HasSlugInterface, HasInputPlaceholderInterface, SimpleTextValue, Searchable, HasQueryModifier, HasRestApiValue
{
    use HasSlug;
    use HasInputPlaceholder;

    public const SEARCH_LOGIC = 'search_logic';
    public const SEARCH_LOGIC_AND = 'and';
    public const SEARCH_LOGIC_OR = 'or';
    public const MULTIPLE_VALUES = 'multiple_values';
    public const PARENT_TAXONOMY_FIELDS = 'parent_taxonomy_fields';
    public const STRICT_PARENT_TAXONOMY_FIELDS = 'strict_parent_taxonomy_fields';
    public const FIELD_DEPENDENCY = 'field_dependency';
    public const FRONTEND_PANEL_OPTIONS = 'frontend_panel_options';
    public const MULTILEVEL = 'multilevel';
    public const MULTILEVEL_FRONTEND_PANEL_MULTIPLE_VALUES = 'multilevel_frontend_panel_multiple_values';
    public const DISABLE_TERMS_LAZY_LOADING = 'disable_terms_lazy_loading';
    public const SHOW_FIELD_DEPENDENCY_ON_TERM_PAGE = 'show_field_dependency_on_term_page';

    public function setFieldDependency($enable): void
    {
        $this->setMeta(self::FIELD_DEPENDENCY, (int)$enable);
    }

    public function fieldDependency(): bool
    {
        return !empty($this->getMeta(self::FIELD_DEPENDENCY));
    }

    public function setStrictParentTaxonomyFields($mode): void
    {
        $this->setMeta(self::STRICT_PARENT_TAXONOMY_FIELDS, (string)$mode);
    }

    public function getStrictParentTaxonomyFieldsMode(): string
    {
        $mode = (string)$this->getMeta(self::STRICT_PARENT_TAXONOMY_FIELDS);
        if (empty($mode)) {
            return 'disabled';
        }

        return $mode;
    }

    public function setParentTaxonomyFields($parentTaxonomyFieldIds): void
    {
        $this->setMeta(self::PARENT_TAXONOMY_FIELDS, $parentTaxonomyFieldIds);
    }

    public function getParentTaxonomyFieldIds(): array
    {
        $ids = $this->getMeta(self::PARENT_TAXONOMY_FIELDS);

        if (empty($ids) || !is_array($ids)) {
            return [];
        }

        return array_map(static function ($id) {
            return (int)$id;
        }, $ids);
    }

    /**
     * @return Collection|TaxonomyField[]
     */
    public function getParentTaxonomyFields(): Collection
    {
        $parentTaxonomyFieldIds = $this->getParentTaxonomyFieldIds();
        if (empty($parentTaxonomyFieldIds)) {
            return tdf_collect();
        }

        return tdf_collect($parentTaxonomyFieldIds)->map(static function ($parentTaxonomyFieldId) {
            return tdf_taxonomy_fields()->find(static function ($parentTaxonomyField) use ($parentTaxonomyFieldId) {
                /* @var TaxonomyField $parentTaxonomyField */
                return $parentTaxonomyField->getId() === $parentTaxonomyFieldId;
            });
        })->filter(static function ($parentTaxonomyField) {
            return $parentTaxonomyField !== false && $parentTaxonomyField !== null;
        });
    }

    /**
     * @param TaxonomyField|int $taxonomy
     *
     * @return bool
     */
    public function isParentTaxonomy($taxonomy): bool
    {
        $parentTaxonomyIds = $this->getParentTaxonomyFieldIds();

        if (empty($parentTaxonomyIds)) {
            return false;
        }

        if ($taxonomy instanceof self) {
            return in_array($taxonomy->getId(), $parentTaxonomyIds, true);
        }

        return in_array((int)$taxonomy, $parentTaxonomyIds, true);
    }

    public function setMultipleValues($allow): void
    {
        $this->setMeta(self::MULTIPLE_VALUES, (int)$allow);
    }

    public function multipleValues(): bool
    {
        return !empty($this->getMeta(self::MULTIPLE_VALUES)) || $this->isMultilevel();
    }

    public function setSearchLogic($logic): void
    {
        $this->setMeta(self::SEARCH_LOGIC, $logic);
    }

    public function getSearchLogic(): string
    {
        if ($this->isMultilevel()) {
            return self::SEARCH_LOGIC_AND;
        }

        $logic = $this->getMeta(self::SEARCH_LOGIC);

        if (empty($logic)) {
            return self::SEARCH_LOGIC_AND;
        }

        return $logic;
    }

    public function isSearchLoginOr(): bool
    {
        return $this->getSearchLogic() === self::SEARCH_LOGIC_OR;
    }

    public function setFrontendPanelOptions($termIds): void
    {
        $this->setMeta(self::FRONTEND_PANEL_OPTIONS, $termIds);
    }

    public function getFrontendPanelOptionIds(): array
    {
        $termIds = $this->getMeta(self::FRONTEND_PANEL_OPTIONS);

        if (!is_array($termIds)) {
            return [];
        }

        return tdf_collect($termIds)->map(static function ($id) {
            return (int)$id;
        })->values();
    }

    public function isFrontendPanelOption($termId): bool
    {
        return in_array((int)$termId, $this->getFrontendPanelOptionIds(), true);
    }

    /**
     * @return Collection|CustomTerm[]
     */
    public function getFrontendPanelOptions(): Collection
    {
        $ids = $this->getFrontendPanelOptionIds();
        if (empty($ids)) {
            return tdf_collect();
        }

        return tdf_query_terms($this->getKey())
            ->in($ids)
            ->get();
    }

    public function getSettingKeys(): array
    {
        return array_merge(parent::getSettingKeys(), [
            self::SLUG,
            self::INPUT_PLACEHOLDER,
            self::SEARCH_LOGIC,
            self::MULTIPLE_VALUES,
            self::PARENT_TAXONOMY_FIELDS,
            self::STRICT_PARENT_TAXONOMY_FIELDS,
            self::FIELD_DEPENDENCY,
            self::FRONTEND_PANEL_OPTIONS,
            self::MULTILEVEL,
            self::DISABLE_TERMS_LAZY_LOADING,
            self::SHOW_FIELD_DEPENDENCY_ON_TERM_PAGE,
            self::MULTILEVEL_FRONTEND_PANEL_MULTIPLE_VALUES,
        ]);
    }

    /**
     * @return Collection|Term[]
     */
    public function getTerms(): Collection
    {
        $query = tdf_query_terms($this->getKey());

        if (function_exists('customtaxorder_sort_taxonomies')) {
            $query->orderBy3rdPartyPlugin();
        }

        return $query->get();
    }

    public function getTermsWithFieldDependencies(): Collection
    {
        $query = tdf_query_terms($this->getKey());

        if (function_exists('customtaxorder_sort_taxonomies')) {
            $query->orderBy3rdPartyPlugin();
        }

        $query->metaQuery([
            'relation' => 'AND',
            [
                'key' => CustomTerm::FIELD_DEPENDENCIES,
                'value' => ['', '0', 'a:0:{}'],
                'compare' => 'NOT IN',
            ],
            [
                'key' => CustomTerm::FIELD_DEPENDENCIES,
                'compare' => 'EXISTS',
            ],
        ]);

        return $query->get();
    }

    /**
     * @return Collection|CustomTerm[]
     */
    public function getMainTerms(): Collection
    {
        return tdf_query_terms($this->getKey())->setParent(0)->get();
    }

    public function getMainTermsList(): array
    {
        $list = [];

        foreach ($this->getMainTerms() as $term) {
            $list[$term->getKey()] = $term->getName();
        }

        return $list;
    }

    public function getMultilevelTermsTree(bool $withTerm = false): array
    {
        $groupedTerms = $this->groupTermsByParent($withTerm);

        return $this->createMultilevelTermTree($groupedTerms, $groupedTerms[0]);
    }

    private function groupTermsByParent(bool $withTerm): array
    {
        $terms = [];

        foreach ($this->getTerms() as $term) {
            /* @var CustomTerm $term */
            $termData = [
                'id' => $term->getId(),
                'label' => $term->getName(),
            ];

            if ($withTerm) {
                $termData['term'] = $term;
            }

            $terms[$term->getMultiLevelParent()][] = $termData;
        }

        return $terms;
    }

    public function createMultilevelTermTree(array &$list, array $parent): array
    {
        $tree = [];

        foreach ($parent as $l) {
            /* @var CustomTerm $l */
            if (isset($list[$l['id']])) {
                $l['children'] = $this->createMultilevelTermTree($list, $list[$l['id']]);
            }

            $tree[] = $l;
        }

        return $tree;
    }

    /**
     * @param Fieldable $fieldable
     * @return Collection|CustomTerm[]
     */
    public function getValue(Fieldable $fieldable): Collection
    {
        if (!$this->isValueVisible()) {
            return tdf_collect();
        }

        $terms = wp_get_object_terms($fieldable->getId(), $this->getKey());

        if (!is_array($terms)) {
            return tdf_collect();
        }

        return tdf_collect($terms)
            ->map(function ($term) {
                return tdf_term_factory()->create($term);
            })
            ->filter(static function ($term) {
                return $term instanceof CustomTerm;
            });
    }

    protected function sortTermsHierarchically(array &$cats, array &$into, $parentId = 0): void
    {
        foreach ($cats as $i => $cat) {
            if ($cat->parent === $parentId) {
                $into[$cat->term_id] = $cat;
                unset($cats[$i]);
            }
        }

        foreach ($into as $topCat) {
            $topCat->children = array();
            $this->sortTermsHierarchically($cats, $topCat->children, $topCat->term_id);
        }
    }

    /**
     * @param Fieldable $fieldable
     * @return Collection|CustomTerm[]
     */
    public function getMultilevelValue(Fieldable $fieldable): Collection
    {
        $value = [];

        foreach ($this->getValue($fieldable) as $term) {
            $value[$term->getMultilevelParentId()][] = [
                'id' => $term->getId(),
                'term' => $term,
            ];
        }

        if (empty($value) || !isset($value[0])) {
            return tdf_collect();
        }

        return $this->getMultilevelValues($this->createMultilevelTermTree($value, $value[0]));
    }

    public function getMultilevelValues(array $list): Collection
    {
        $terms = tdf_collect();

        $this->extractTermsRecursively($list, $terms);

        return $terms;
    }

    private function extractTermsRecursively(array $list, Collection $terms): void
    {
        foreach ($list as $term) {
            $terms[] = $term['term'];

            if (isset($term['children'])) {
                $this->extractTermsRecursively($term['children'], $terms);
            }
        }
    }

    public function setValue(Fieldable $fieldable, $value): bool
    {
        return !is_wp_error(wp_set_object_terms($fieldable->getId(), $value, $this->getKey()));
    }

    public function getSimpleTextValue(Fieldable $fieldable, bool $label = false): array
    {
        if ($this->isMultilevel()) {
            return $this->getMultilevelValue($fieldable)->map(static function ($term) {
                /* @var Term $term */
                return $term->getName();
            })->values();
        }

        return $this->getValue($fieldable)->map(static function ($term) {
            /* @var Term $term */
            return $term->getName();
        })->values();
    }

    public function getSearchField(array $config): SearchField
    {
        return new TaxonomySearchField($this, $config);
    }

    public function getQueryModifier(): QueryModifier
    {
        return new TaxonomyQueryModifier($this);
    }

    public function setMultilevel($enable): void
    {
        $this->setMeta(self::MULTILEVEL, (int)$enable);
    }

    public function isMultilevel(): bool
    {
        return !empty((int)$this->getMeta(self::MULTILEVEL));
    }

    public function setMultilevelFrontendPanelMultipleValues($allow): void
    {
        $this->setMeta(self::MULTILEVEL_FRONTEND_PANEL_MULTIPLE_VALUES, (int)$allow);
    }

    public function multilevelFrontendPanelMultipleValues(): bool
    {
        return !empty((int)$this->getMeta(self::MULTILEVEL_FRONTEND_PANEL_MULTIPLE_VALUES));
    }

    public function jsonSerialize(): array
    {
        return parent::jsonSerialize() + [
                'multiple' => $this->multipleValues(),
                'multilevel' => $this->isMultilevel(),
                'parentFieldIds' => $this->getParentTaxonomyFieldIds(),
                'strictParentTaxonomyFields' => $this->getStrictParentTaxonomyFieldsMode(),
            ];
    }

    public static function getAllTermList(): array
    {
        $terms = [];

        foreach (tdf_taxonomy_fields() as $taxonomy) {
            /* @var TaxonomyField $taxonomy */
            foreach ($taxonomy->getTerms() as $term) {
                $terms[] = $term;
            }
        }

        usort($terms, static function ($a, $b) {
            return strcmp($a->getName(), $b->getName());
        });

        return $terms;
    }

    public function getTypeLabel(): string
    {
        return tdf_admin_string('taxonomy');
    }

    public function getApiEndpoint(): string
    {
        return get_rest_url() . 'wp/v2/' . $this->getKey() . '?per_page=100';
    }

    /**
     * @param Fieldable $fieldable
     * @return mixed|Collection|CustomTerm[]
     */
    public function getRestApiValue(Fieldable $fieldable)
    {
        return $this->getValue($fieldable)->map(static function ($term) {
            /* @var Term $term */
            return $term->getName();
        });
    }

    public function setDisableTermsLazyLoading($disable): void
    {
        $this->setMeta(self::DISABLE_TERMS_LAZY_LOADING, (int)$disable);
    }

    public function isTermsLazyLoadingDisabled(): bool
    {
        return !empty((int)$this->getMeta(self::DISABLE_TERMS_LAZY_LOADING));
    }

    public function setShowFieldDependencyOnTermPage($show): void
    {
        $this->setMeta(self::SHOW_FIELD_DEPENDENCY_ON_TERM_PAGE, (int)$show);
    }

    public function showFieldDependencyOnTermPage(): bool
    {
        return !empty((int)$this->getMeta(self::SHOW_FIELD_DEPENDENCY_ON_TERM_PAGE));
    }
}