<?php

namespace Tangibledesign\Framework\Search\QueryModifier;

use Tangibledesign\Framework\Search\Helpers\QueryModels;
use Tangibledesign\Framework\Search\SearchResultsModifier;
use Tangibledesign\Framework\Search\SearchUrlModifier;

class KeywordQueryModifier extends QueryModifier implements SearchUrlModifier, SearchResultsModifier
{
    use QueryModels;

    /**
     * @param string $postType
     * @param array $filters
     * @return false|int[]
     */
    public function getModelIds(string $postType, array $filters)
    {
        $filter = $this->getFilter('keyword', $filters);
        if (!$filter || empty($filter['values'])) {
            return false;
        }

        return $this->queryModels($postType, $this->getModelIdsArgs($filter));
    }

    /**
     * @param array $filter
     * @return array
     */
    private function getModelIdsArgs(array $filter): array
    {
        if (tdf_settings()->keywordSearchDescription()) {
            return [
                'search_keyword' => $filter['values'][0],
            ];
        }

        return [
            'search_title' => $filter['values'][0],
        ];
    }

    /**
     * @return array
     */
    public function getFiltersFromUrl(): array
    {
        if (!isset($_GET[tdf_slug('keyword')]) || empty($_GET[tdf_slug('keyword')])) {
            return [];
        }

        return [
            [
                'key' => 'keyword',
                'values' => [stripslashes_deep($_GET[tdf_slug('keyword')])],
                'type' => 'regular',
                'label' => stripslashes_deep($_GET[tdf_slug('keyword')]),
            ]
        ];
    }

    /**
     * @param array $filters
     * @param array $params
     * @return string
     */
    public function geSearchUrlPartials(array $filters, array $params): string
    {
        $filter = $this->getFilter('keyword', $filters);
        if (!$filter) {
            return '';
        }

        $value = $this->getUrlValue($filter);
        if (empty($value)) {
            return '';
        }

        return tdf_slug('keyword') . '=' . $value;
    }

    /**
     * @param array $filter
     * @return string
     */
    private function getUrlValue(array $filter): string
    {
        if (!isset($filter['values'])) {
            return '';
        }

        return implode('', $filter['values']);
    }

}