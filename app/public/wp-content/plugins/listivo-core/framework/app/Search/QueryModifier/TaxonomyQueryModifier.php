<?php

namespace Tangibledesign\Framework\Search\Query;

use Tangibledesign\Framework\Search\Helpers\QueryModels;
use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;
use Tangibledesign\Framework\Search\SearchResultsModifier;
use Tangibledesign\Framework\Search\SearchUrlModifier;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use WP_Term;

class TaxonomyQueryModifier extends QueryModifier implements SearchUrlModifier, SearchResultsModifier
{
    use QueryModels;

    /**
     * @var TaxonomyField
     */
    private $field;

    public function __construct(TaxonomyField $taxonomyField)
    {
        $this->field = $taxonomyField;
    }

    public function getField(): TaxonomyField
    {
        return $this->field;
    }

    public function geSearchUrlPartials(array $filters, array $params): string
    {
        $filter = $this->getFilter($this->field->getKey(), $filters);
        if (!$filter) {
            return '';
        }

        $value = $this->getUrlValue($filter);
        if (empty($value)) {
            return '';
        }

        return $this->field->getSlug() . '=' . $value;
    }

    private function getUrlValue(array $filter): string
    {
        return tdf_query_terms($filter['key'])
            ->in(tdf_collect($filter['values'])
                ->map(static function ($termId) {
                    return (int)$termId;
                })
                ->values()
            )
            ->orderByIn()
            ->get()
            ->map(static function (CustomTerm $term) {
                return $term->getSlug();
            })
            ->implode(',');
    }

    /**
     * @param string $postType
     * @param array $filters
     * @return int[]|false
     */
    public function getModelIds(string $postType, array $filters)
    {
        $filter = $this->getFilter($this->field->getKey(), $filters);
        if (!$filter) {
            return false;
        }

        if ($this->getCompareOperator() === 'IN') {
            return $this->taxQueryModels($postType, [
                'taxonomy' => $this->field->getKey(),
                'field' => 'term_id',
                'terms' => $filter['values'],
                'operator' => $this->getCompareOperator(),
            ]);
        }

        $query = [
            'relation' => 'AND'
        ];

        foreach ($filter['values'] as $termId) {
            $query[] = [
                'taxonomy' => $this->field->getKey(),
                'field' => 'term_id',
                'terms' => $termId,
                'operator' => 'IN',
            ];
        }

        return $this->taxQueryModels($postType, $query);
    }

    private function getCompareOperator(): string
    {
        return $this->field->getSearchLogic() === TaxonomyField::SEARCH_LOGIC_OR ? 'IN' : 'AND';
    }

    public function getFiltersFromUrl(): array
    {
        $slug = $this->field->getSlug();
        $value = get_query_var($this->field->getKey());

        if (empty($value)) {
            if (empty($_GET[$slug])) {
                return [];
            }

            $value = $_GET[$slug];
        }

        $termSlugs = explode(',', $value);
        if (empty($termSlugs)) {
            return [];
        }

        $terms = get_terms([
            'taxonomy' => $this->field->getKey(),
            'hide_empty' => false,
            'slug' => $termSlugs,
            'orderby' => 'slug__in',
        ]);

        if (!is_array($terms) || empty($terms)) {
            return [];
        }

        return [
            [
                'key' => $this->field->getKey(),
                'values' => tdf_collect($terms)->map(static function ($term) {
                    /* @var WP_Term $term */
                    return $term->term_id;
                })->values(),
                'type' => 'taxonomy',
                'terms' => tdf_collect($terms)->map(static function ($term) {
                    /* @var WP_Term $term */
                    return [
                        'id' => $term->term_id,
                        'name' => $term->name,
                    ];
                })
            ]
        ];
    }
}