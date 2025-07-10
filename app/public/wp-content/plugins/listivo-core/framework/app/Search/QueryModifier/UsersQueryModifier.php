<?php

namespace Tangibledesign\Framework\Search\QueryModifier;

use Tangibledesign\Framework\Search\Helpers\QueryModels;
use Tangibledesign\Framework\Search\SearchResultsModifier;

class UsersQueryModifier extends QueryModifier implements SearchResultsModifier
{
    use QueryModels;

    public function getModelIds(string $postType, array $filters)
    {
        $filter = $this->getFilter('users', $filters);
        if (!$filter || empty($filter['values'])) {
            return false;
        }

        return $this->queryModels($postType, [
            'author__in' => $filter['values'],
        ]);
    }

    public function getFiltersFromUrl(): array
    {
        $values = $this->fetchValuesFromUrl();
        if (empty($values)) {
            return [];
        }

        return [
            [
                'key' => 'users',
                'values' => $values,
                'type' => 'regular',
                'label' => 'Users',
            ]
        ];
    }

    private function fetchValuesFromUrl(): array
    {
        if (!isset($_GET[tdf_slug('users')]) || empty($_GET[tdf_slug('users')])) {
            return [];
        }

        $userIds = explode(',', tdf_slug('users'));

        return tdf_collect($userIds)->map(function ($userId) {
            return (int)$userId;
        })->values();
    }

}