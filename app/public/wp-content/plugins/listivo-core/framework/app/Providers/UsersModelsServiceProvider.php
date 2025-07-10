<?php

namespace Tangibledesign\Framework\Providers;

use JsonException;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Search\SearchModels;
use Tangibledesign\Framework\Search\Sortable;

class UsersModelsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/users/models/template', [$this, 'template']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/users/models/template', [$this, 'template']);
    }

    public function template(): void
    {
        $userIds = $this->getUserIds();
        if (empty($userIds)) {
            return;
        }

        $limit = $this->getLimit();

        $query = tdf_query_models()
            ->userIn($userIds)
            ->setTaxQuery($this->getTaxQuery())
            ->take($limit)
            ->orderBy($this->getSortBy())
            ->setPage($this->getPage());

        try {
            echo json_encode([
                'template' => $this->fetchTemplate($query->get()),
                'count' => $query->getResultsNumber(),
                'termsCount' => $this->getTermsCount(),
            ], JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return;
        }
    }

    private function getTermsCount(): array
    {
        return (new SearchModels())
            ->getTermsCount($this->getSearchFilters());
    }

    private function getSearchFilters(): array
    {
        $filters = [];

        foreach ($this->getFilters() as $taxonomyKey => $termIds) {
            $filters[] = [
                'key' => $taxonomyKey,
                'values' => $termIds,
            ];
        }

        $filters[] = [
            'key' => 'users',
            'values' => $this->getUserIds(),
        ];

        return $filters;
    }

    private function getUserIds(): array
    {
        $userIds = $_POST['userIds'] ?? [];
        if (!is_array($userIds)) {
            return [];
        }

        return tdf_collect($userIds)
            ->map(function ($userId) {
                return (int)$userId;
            })
            ->filter(function ($userId) {
                return $userId > 0;
            })
            ->values();
    }

    private function getLimit(): int
    {
        $limit = (int)($_POST['limit'] ?? 6);
        if ($limit < 1) {
            return 6;
        }

        if ($limit > 100) {
            return 6;
        }

        return $limit;
    }

    private function getPage(): int
    {
        $page = (int)($_POST['page'] ?? 1);
        if ($page < 1) {
            return 1;
        }

        return $page;
    }

    private function fetchTemplate(Collection $models): string
    {
        ob_start();

        get_template_part($this->getTemplate(), args: [
            'models' => $models,
        ]);

        return ob_get_clean();
    }

    private function getTemplate(): string
    {
        return $_POST['template'] ?? '';
    }

    private function getFilters(): array
    {
        $filters = $_POST['filters'] ?? [];
        if (!is_array($filters)) {
            return [];
        }

        return $filters;
    }

    private function getTaxQuery(): array
    {
        $filters = $this->getFilters();

        $taxQuery = [];

        foreach ($filters as $taxonomyKey => $termIds) {
            if (!is_array($termIds)) {
                continue;
            }

            if (empty($termIds)) {
                continue;
            }

            $taxQuery[] = [
                'taxonomy' => $taxonomyKey,
                'field' => 'term_id',
                'terms' => $termIds,
            ];
        }

        return $taxQuery;
    }

    private function getSortBy(): string
    {
        $options = [
            tdf_slug('newest'),
            tdf_slug('oldest'),
            tdf_slug('most_relevant'),
            tdf_slug('name_asc'),
            'random',
        ];

        $sortBy = $_POST['sortBy'] ?? '';
        if (empty($sortBy)) {
            return tdf_slug('newest');
        }

        foreach (tdf_app('sortable_fields') as $sortableField) {
            /* @var Sortable $sortableField */
            $options[] = $sortableField->getSlug() . '-' . tdf_slug('high_to_low');
            $options[] = $sortableField->getSlug() . '-' . tdf_slug('low_to_high');
        }

        if (!in_array($sortBy, $options, true)) {
            return tdf_slug('most_relevant');
        }

        return $sortBy;
    }
}