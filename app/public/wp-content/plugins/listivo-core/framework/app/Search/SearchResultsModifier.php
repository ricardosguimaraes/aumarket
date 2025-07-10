<?php

namespace Tangibledesign\Framework\Search;

interface SearchResultsModifier
{
    /**
     * @param  string  $postType
     * @param  array  $filters
     * @return int[]|false
     */
    public function getModelIds(string $postType, array $filters);

    public function getFiltersFromUrl(): array;

}