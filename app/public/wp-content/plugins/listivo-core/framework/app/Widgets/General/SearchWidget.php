<?php

namespace Tangibledesign\Framework\Widgets\General;

use Tangibledesign\Framework\Actions\Search\SearchTitleAndDescriptionAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Search\SearchModels;
use Tangibledesign\Framework\Search\SearchResultsModifier;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\LimitControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SearchFieldsControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SortByControls;
use Tangibledesign\Framework\Widgets\Helpers\HasUser;

abstract class SearchWidget extends BaseGeneralWidget
{
    use SearchFieldsControl;
    use SortByControls;
    use LimitControl;
    use HasUser;

    protected ?int $count = null;
    protected array $termCount = [];
    protected array $markers = [];
    protected ?array $initialFilters = null;
    protected ?Collection $results = null;

    protected SearchTitleAndDescriptionAction $searchTitleAndDescriptionAction;

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();

        $this->searchTitleAndDescriptionAction = new SearchTitleAndDescriptionAction();
    }

    protected function getTemplateDirectory(): string
    {
        return 'general/search/';
    }

    protected function addGeneralSection(): void
    {
        $this->startContentControlsSection();

        $this->addLimitControl();

        $this->endControlsSection();
    }

    protected function addSortBySection(): void
    {
        $this->startContentControlsSection('sort_by_section', tdf_admin_string('sort_by'));

        $this->addSortByControls();

        $this->endControlsSection();
    }

    public function getInitialFilters(): array
    {
        if (is_array($this->initialFilters)) {
            return $this->initialFilters;
        }

        $filters = [];

        foreach (tdf_app('search_results_modifiers') as $searchResultsModifier) {
            /* @var SearchResultsModifier $searchResultsModifier */
            foreach ($searchResultsModifier->getFiltersFromUrl() as $filter) {
                $filters[] = $filter;
            }
        }

        $this->initialFilters = $filters;

        return $filters;
    }

    public function getSelectedDependencyTerms(array $initialFilters): Collection
    {
        $selectedTermIds = [];

        tdf_collect($initialFilters)->filter(static function ($filter) {
            return isset($filter['type']) && $filter['type'] === 'taxonomy' && !empty($filter['values']);
        })->each(static function ($filter) use (&$selectedTermIds) {
            foreach ($filter['values'] as $termId) {
                $selectedTermIds[] = (int)$termId;
            }
        });

        /** @noinspection NullPointerExceptionInspection */
        return tdf_app('dependency_terms')->filter(static function ($term) use ($selectedTermIds) {
            /* @var CustomTerm $term */
            return in_array($term->getId(), $selectedTermIds, true);
        });
    }

    public function getCount(): int
    {
        if ($this->count !== null) {
            return $this->count;
        }

        $this->getResults();

        return $this->count;
    }

    public function getTermCount(): array
    {
        return $this->termCount;
    }

    public function getSearchTitle(): string
    {
        return $this->searchTitleAndDescriptionAction->getTitle();
    }

    public function getSearchDescription(): string
    {
        return $this->searchTitleAndDescriptionAction->getDescription();
    }

    public function get_script_depends(): array
    {
        return ['google-maps'];
    }

    private function getInitialParams(): array
    {
        $params = [];

        if (is_author()) {
            $user = $this->getUser();
            if ($user) {
                $params['userIds'] = [$user->getId()];
            }
        }

        return $params;
    }

    public function getListings(array $filters = []): Collection
    {
        $search = new SearchModels($this->getInitialParams(), $this->locationField);

        $ids = $search->getModelIds(tdf_app('search_results_modifiers'), $filters, $this->getParams());

        $this->count = $search->getCount();

        $this->termCount = $search->getTermsCount($filters);

        if ($this->map && $ids !== false) {
            $this->markers = $search->getMarkers($ids);
        } else {
            $this->markers = [];
        }

        return tdf_query_models()
            ->in($ids)
            ->orderByIn()
            ->get();
    }

    private function getParams(): array
    {
        $params = $_GET + [
                'limit' => $this->getLimit()
            ];

        foreach (tdf_app('breadcrumbs_taxonomies') as $taxonomy) {
            /* @var TaxonomyField $taxonomy */
            $value = get_query_var($taxonomy->getKey());
            if (!empty($value)) {
                $params[$taxonomy->getSlug()] = $value;
            }
        }

        $params[tdf_slug('sort-by')] = $this->getInitialSortBy();

        return $params;
    }

    public function getResults(): Collection
    {
        if ($this->results !== null) {
            return $this->results;
        }

        $this->results = $this->getListings($this->getInitialFilters());

        return $this->results;
    }

    public function getCurrentPage(): int
    {
        return (int)($_GET[tdf_slug('pagination')] ?? 1);
    }
}