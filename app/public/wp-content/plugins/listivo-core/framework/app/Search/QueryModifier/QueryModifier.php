<?php

namespace Tangibledesign\Framework\Search\QueryModifier;

abstract class QueryModifier
{
    /**
     * @param string $key
     * @param array $filters
     * @return array|false
     */
    protected function getFilter(string $key, array $filters)
    {
        foreach ($filters as $filter) {
            if ($filter['key'] === $key) {
                return $filter;
            }
        }

        return false;
    }
}