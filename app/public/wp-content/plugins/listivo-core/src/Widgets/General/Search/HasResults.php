<?php

namespace Tangibledesign\Listivo\Widgets\General\Search;

use Tangibledesign\Framework\Core\Collection;

interface HasResults
{
    /**
     * @return Collection
     */
    public function getResults(): Collection;

    /**
     * @return bool
     */
    public function hideSearchResultsBar(): bool;

    /**
     * @return bool
     */
    public function showSortBy(): bool;

    /**
     * @return array
     */
    public function getSortByOptions(): array;

    /**
     * @return bool
     */
    public function showViewSelector(): bool;

    /**
     * @return string
     */
    public function getCardTemplatePath(): string;

    /**
     * @return string
     */
    public function getRowCardTemplatePath(): string;

    /**
     * @return string
     */
    public function getInitialTemplate(): string;

    /**
     * @return int
     */
    public function getLimit(): int;

    /**
     * @return bool
     */
    public function showSearchFilters(): bool;

}