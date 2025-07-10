<?php


namespace Tangibledesign\Framework\Search;


/**
 * Interface SearchParamsModifier
 * @package Tangibledesign\Framework\Search
 */
interface SearchParamsModifier
{
    /**
     * @param array $queryArgs
     * @param array $params
     * @return array
     */
    public function applyParams(array $queryArgs, array $params): array;

}