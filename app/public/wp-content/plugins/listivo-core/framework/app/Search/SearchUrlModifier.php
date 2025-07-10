<?php


namespace Tangibledesign\Framework\Search;


/**
 * Interface SearchUrlModifier
 * @package Tangibledesign\Framework\Search
 */
interface SearchUrlModifier
{
    /**
     * @param array $filters
     * @param array $params
     * @return string
     */
    public function geSearchUrlPartials(array $filters, array $params): string;
}