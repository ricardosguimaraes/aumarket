<?php

namespace Tangibledesign\Framework\Search;

use Tangibledesign\Framework\Actions\Search\SearchTitleAndDescriptionAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Search\Query\TaxonomyQueryModifier;
use WP_Query;

class SearchModels
{
    protected string $postType = '';
    protected array $params;
    protected ?int $count = null;
    protected static array $cache = [];
    protected ?Collection $urlPartials = null;
    protected bool $includeExcluded = false;
    protected ?LocationField $locationField = null;
    protected ?array $modelExcludedByLocationIds = null;
    protected ?Collection $listings = null;
    protected ?array $initialModelIds = null;

    public function __construct(array $params = [], ?LocationField $locationField = null)
    {
        $this->params = $params;

        $this->locationField = $locationField;

        $this->postType = tdf_model_post_type();
    }

    public function includeExcluded(): void
    {
        $this->includeExcluded = true;
    }

    private function getFilters(): array
    {
        return $this->params['filters'] ?? [];
    }

    private function getParams(): array
    {
        return $this->params['params'] ?? [];
    }

    private function getUserIds(): array
    {
        $userIds = $this->params['userIds'] ?? [];
        if (empty($userIds)) {
            return [];
        }

        return array_map('intval', $userIds);
    }

    public function getResults(): array
    {
        $filters = $this->getFilters();
        $modelsIds = $this->getModelIds(
            tdf_app('search_results_modifiers'),
            $this->getFilters(),
            $this->getParams()
        );

        if ($modelsIds === false) {
            return [
                'template' => '',
                'url' => $this->getUrl($filters, $this->getParams()),
                'count' => 0,
                'termCount' => [],
                'breadcrumbs' => $this->getBreadcrumbs(),
                'markers' => [],
                'title' => '',
            ];
        }

        $searchTitleAndDescriptionAction = new SearchTitleAndDescriptionAction();

        $response = [
            'url' => $this->getUrl($filters, $this->getParams()),
            'count' => $this->count,
            'termCount' => $this->getTermsCount($filters, $this->getParams()),
            'breadcrumbs' => $this->getBreadcrumbs(),
            'markers' => [],
            'title' => $searchTitleAndDescriptionAction->getTitle($filters),
            'description' => $searchTitleAndDescriptionAction->getDescription($filters),
        ];

        if (!empty($this->params['template'])) {
            $response['template'] = $this->getTemplate($modelsIds);
        }

        if (!empty($this->params['map'])) {
            $response['markers'] = $this->getMarkers($modelsIds);
        }

        return $response;
    }

    private function getModelIdsExcludedByLocationField(): array
    {
        if (is_array($this->modelExcludedByLocationIds)) {
            return $this->modelExcludedByLocationIds;
        }

        if (!$this->locationField) {
            return [];
        }

        $locationFieldKey = $this->locationField->getKey();

        $this->modelExcludedByLocationIds = (new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'fields' => 'ids',
            'post_status' => PostStatus::PUBLISH,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'no_found_rows' => true,
            'meta_query' => [
                'relation' => 'OR',
                [
                    'relation' => 'AND',
                    [
                        'key' => $locationFieldKey . '_lat',
                        'compare' => 'NOT EXISTS'
                    ],
                    [
                        'key' => $locationFieldKey . '_lng',
                        'compare' => 'NOT EXISTS'
                    ],
                ],
                [
                    'relation' => 'AND',
                    [
                        'key' => $locationFieldKey . '_lat',
                        'value' => '0',
                    ],
                    [
                        'key' => $locationFieldKey . '_lng',
                        'value' => '0',
                    ],
                ]
            ]
        ]))->posts;

        return $this->modelExcludedByLocationIds;
    }

    private function getInitialModelIds(): ?array
    {
        if ($this->initialModelIds !== null) {
            return $this->initialModelIds;
        }

        $userIds = $this->getUserIds();
        if (empty($userIds)) {
            return [];
        }

        $this->initialModelIds = (new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'fields' => 'ids',
            'post_status' => PostStatus::PUBLISH,
            'author__in' => $userIds,
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
            'no_found_rows' => true,
        ]))->posts;

        if (empty($this->initialModelIds)) {
            return null;
        }

        return $this->initialModelIds;
    }

    /**
     * @param Collection $searchResultsModifiers
     * @param array $filters
     * @param array $params
     * @return array|false
     */
    public function getModelIds(Collection $searchResultsModifiers, array $filters, array $params = [])
    {
        $modelIds = $this->getInitialModelIds();
        if ($modelIds === null) {
            return false;
        }

        $flag = false;

        foreach ($searchResultsModifiers as $searchResultsModifier) {
            /* @var SearchResultsModifier $searchResultsModifier */
            $ids = $searchResultsModifier->getModelIds($this->postType, $filters);
            if ($ids === false) {
                continue;
            }

            if (empty($ids)) {
                return false;
            }

            if (!$flag) {
                $modelIds = $ids;
                $flag = true;
            } else {
                $modelIds = array_intersect($modelIds, $ids);
            }
        }

        $modelIds = array_values(array_unique($modelIds));
        if (!$this->includeExcluded) {
            $modelIds = $this->filterExcludedFromSearch($modelIds);
        }

        if ($modelIds === null || ($flag && empty($modelIds))) {
            return false;
        }

        $modelIds = tdf_collect($modelIds)->filter(static function ($modelId) {
            return !in_array($modelId, tdf_app('models_excluded_from_search'), true);
        })->values();

        return $this->applyParams($modelIds, $params, true);
    }

    private function applyParams(array $modelIds, array $params, bool $setCount = false): array
    {
        $args = [
            'post_type' => $this->postType,
            'post__in' => $modelIds,
            'posts_per_page' => -1,
            'post_status' => PostStatus::PUBLISH,
            'fields' => 'ids',
            'author__in' => $this->getUserIds(),
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ];

        if (!$this->includeExcluded) {
            $args['post__not_in'] = array_merge(tdf_app('models_excluded_from_search'),
                $this->getModelIdsExcludedByLocationField());
        } else {
            $args['post__not_in'] = $this->getModelIdsExcludedByLocationField();
        }

        $args['post__not_in'] = apply_filters(tdf_prefix() . '/search/excluded', $args['post__not_in']);

        if (!empty($args['post__in']) && !empty($args['post__not_in'])) {
            $args['post__in'] = tdf_collect($args['post__in'])->filter(static function ($id) use ($args) {
                return !in_array($id, $args['post__not_in'], true);
            })->values();
        }

        foreach (tdf_app('search_params_modifiers') as $searchParamModifier) {
            /* @var SearchParamsModifier $searchParamModifier */
            $args = $searchParamModifier->applyParams($args, $params) + $args;
        }

        $cacheKey = md5(json_encode($args));
        if (!isset(self::$cache[$cacheKey])) {
            $query = new WP_Query($args);
            if ($setCount) {
                if ($args['posts_per_page'] === -1) {
                    self::$cache[$cacheKey . '_count'] = count($query->posts);
                } elseif (isset($args['meta_key']) && $args['meta_key'] === 'featured') {
                    $tempArgs = $args;
                    unset($tempArgs['orderby'], $tempArgs['meta_key']);

                    self::$cache[$cacheKey . '_count'] = (new WP_Query($tempArgs))->found_posts;
                } else {
                    self::$cache[$cacheKey . '_count'] = $query->found_posts;
                }

                $this->count = self::$cache[$cacheKey . '_count'];
            }
            self::$cache[$cacheKey] = $query->posts;
        } elseif ($setCount) {
            $this->count = self::$cache[$cacheKey . '_count'];
        }

        return self::$cache[$cacheKey];
    }

    public function getUrl(array $filters, array $params): string
    {
        $urlPartials = tdf_collect();

        foreach (tdf_app('search_url_modifiers') as $searchUrlModifier) {
            /* @var SearchUrlModifier $searchUrlModifier */
            $urlPartials[] = $searchUrlModifier->geSearchUrlPartials($filters, $params);
        }

        $this->urlPartials = apply_filters(tdf_prefix() . '/search/urlPartials', $urlPartials,
            $this->params['template'] ?? '');

        $url = apply_filters(tdf_prefix() . '/term/url', $this->urlPartials->filter(static function ($urlPartial) {
            return !empty($urlPartial);
        })->implode('&'), false, false);

        if (tdf_settings()->prettyUrls()) {
            return $url !== '?=' ? $url : '';
        }

        if (!empty($url) && !str_contains($url, '?')) {
            $url = '?' . $url;
        }

        return $url !== '?=' ? $url : '';
    }

    public function getCount(): int
    {
        return $this->count ?? 0;
    }

    private function filterExcludedFromSearch(array $modelIds): ?array
    {
        if (empty($modelIds)) {
            return $modelIds;
        }

        if (empty(tdf_settings()->getExcludedFromSearchTermIds())) {
            return $modelIds;
        }

        $modelIds = tdf_collect($modelIds)->filter(static function ($modelId) {
            return !in_array((int)$modelId, tdf_app('models_excluded_from_search'), true);
        })->values();

        if (empty($modelIds)) {
            return null;
        }

        return $modelIds;
    }

    public function getTermsCount(array $filters = [], array $params = []): array
    {
        $allTerms = [];

        tdf_taxonomy_fields()->each(function ($taxonomy) use ($params, &$allTerms, $filters) {
            /* @var TaxonomyField $taxonomy */
            /** @noinspection NullPointerExceptionInspection */
            $searchFilters = tdf_app('search_results_modifiers')
                ->filter(static function ($searchFilter) use ($taxonomy) {
                    if (!$searchFilter instanceof TaxonomyQueryModifier) {
                        return true;
                    }

                    $searchFilterTaxonomy = $searchFilter->getField();

                    return !(
                        ($searchFilterTaxonomy->getId() === $taxonomy->getId() && ($taxonomy->isSearchLoginOr() || $taxonomy->isMultilevel()))
//                        || $taxonomy->isParentTaxonomy($searchFilterTaxonomy)
                        || $searchFilterTaxonomy->isParentTaxonomy($taxonomy)
                    );
                });

            $allTerms = array_merge(
                $allTerms,
                $this->getTermsCountForTaxonomy($taxonomy, $this->getModelIds($searchFilters, $filters))
            );
        });

        return $allTerms;
    }

    private function getTermsCountForTaxonomy(TaxonomyField $taxonomy, $modelIds = []): array
    {
        if ($modelIds === false) {
            $cacheKey = tdf_prefix() . '_cache_' . $taxonomy->getKey() . '_count';
            if (isset(self::$cache[$cacheKey])) {
                $modelIds = self::$cache[$cacheKey];
            } else {
                $query = new WP_Query([
                    'post_type' => $this->postType,
                    'posts_per_page' => '-1',
                    'fields' => 'ids',
                    'post_status' => PostStatus::PUBLISH,
                    'author__in' => $this->getUserIds(),
                    'update_post_meta_cache' => false,
                    'update_post_term_cache' => false,
                    'no_found_rows' => true,
                ]);

                self::$cache[$cacheKey] = $query->posts;

                $modelIds = $query->posts;
            }
        }

        $modelIdsString = implode(',', $modelIds);

        $cacheKey = tdf_prefix() . '_cache_' . $taxonomy->getKey() . '_' . md5($modelIdsString) . '_count';
        if (isset(self::$cache[$cacheKey])) {
            return self::$cache[$cacheKey];
        }

        if (tdf_settings()->isCacheEnabled()) {
            $value = get_transient($cacheKey);
            if ($value !== false) {
                self::$cache[$cacheKey] = $value;

                return $value;
            }
        }

        global $wpdb;
        if (empty($modelIds)) {
            $modelIdsQuery = 'AND p.post_status = "publish"';

            $sql = "
                SELECT tt.term_id as id, COUNT(tr.term_taxonomy_id) as count FROM {$wpdb->posts} p
                    LEFT OUTER JOIN {$wpdb->term_relationships} tr ON p.ID = tr.object_id
                    LEFT OUTER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
                WHERE tt.taxonomy = '" . $taxonomy->getKey() . "' $modelIdsQuery
                GROUP BY tr.term_taxonomy_id
            ";

            $terms = $wpdb->get_results($sql);
        } else {
            $terms = $this->fetchTermsCount($taxonomy, $modelIds);
        }

        if (!is_array($terms)) {
            return [
                [
                    'id' => $taxonomy->getKey(),
                    'count' => count($modelIds)
                ]
            ];
        }

        $output = tdf_collect($terms)->map(static function ($term) {
            return [
                'id' => (int)$term->id,
                'count' => (int)$term->count
            ];
        })->values();

        $output[] = [
            'id' => $taxonomy->getKey(),
            'count' => count($modelIds)
        ];

        self::$cache[$cacheKey] = $output;

        if (tdf_settings()->isCacheEnabled()) {
            set_transient($cacheKey, $output, tdf_settings()->getCacheDuration());
        }

        return $output;
    }

    private function fetchTermsCount(TaxonomyField $taxonomy, array $modelIds)
    {
        global $wpdb;

        $modelIdsQuery = "AND tr.object_id IN (" . implode(',', $modelIds) . ")";

        $sql = "
            SELECT tt.term_id as id, COUNT(tr.term_taxonomy_id) as count
            FROM {$wpdb->term_relationships} tr
                LEFT OUTER JOIN {$wpdb->term_taxonomy} tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            WHERE tt.taxonomy = '" . $taxonomy->getKey() . "' $modelIdsQuery
            GROUP BY tr.term_taxonomy_id
            ";

        return $wpdb->get_results($sql);
    }

    private function getBreadcrumbs(): array
    {
        if (!$this->urlPartials instanceof Collection) {
            return [];
        }

        $args = [];

        foreach ($this->urlPartials as $partial) {
            if (empty($partial)) {
                continue;
            }

            $data = explode('=', $partial);
            if (count($data) !== 2) {
                continue;
            }

            $args[$data[0]] = $data[1];
        }

        return apply_filters(tdf_prefix() . '/breadcrumbs/listings', $args);
    }

    private function fetchListings(array $modelIds): void
    {
        global ${tdf_short_prefix() . 'CurrentListings'};

        $this->listings = ${tdf_short_prefix() . 'CurrentListings'} = tdf_query_models()
            ->in($modelIds)
            ->orderByIn()
            ->get();
    }

    public function getTemplate(array $modelIds): string
    {
        if ($this->listings === null) {
            $this->fetchListings($modelIds);
        }

        ob_start();

        if (!in_array($this->params['template'], [
            'templates/widgets/general/search/partials/search_results_card',
            'templates/widgets/general/search/partials/search_results_row',
            // @todo: fix it
            'templates/partials/search_results_card_regular',
            'templates/partials/search_results_card_small',
            'templates/partials/search_results_simple_card',
            'templates/partials/search_results_row',
            'templates/partials/search_results_row_regular',
            'templates/partials/search_results_row_regular_v2',
        ], true)) {
            get_template_part('templates/partials/search_results_row');

//            get_template_part('templates/widgets/general/search/partials/search_results_row');
        } else {
            get_template_part($this->params['template']);
        }

        return ob_get_clean();
    }

    public function getMarkers(array $modelIds): array
    {
        if ($this->listings === null) {
            $this->fetchListings($modelIds);
        }

        $markers = [];
        $mainValueFields = tdf_settings()->getCardMainValueFields();
        $locationField = tdf_settings()->getCardLocationField();

        if (!$locationField instanceof LocationField) {
            $locationField = tdf_location_fields()->first(false);
        }

        global ${tdf_short_prefix() . 'CurrentListings'};
        foreach (${tdf_short_prefix() . 'CurrentListings'} as $listing) {
            /* @var Model $listing */
            $mainValue = '';
            foreach ($mainValueFields as $mainValueField) {
                if (!empty($mainValueField->getValueByCurrency($listing))) {
                    $mainValue = $mainValueField->getValueByCurrency($listing);
                }
            }

            $galleryField = tdf_settings()->getCardGalleryField();

            $markers[] = [
                'id' => $listing->getId(),
                'label' => $listing->getName(),
                'url' => $listing->getUrl(),
                'image' => $galleryField instanceof GalleryField ? $galleryField->getImageUrl($listing) : '',
                'price' => $mainValue,
                'location' => $locationField instanceof LocationField ? $locationField->getLocation($listing) : false,
            ];
        }

        return $markers;
    }
}