<?php


namespace Tangibledesign\Framework\Search\SearchParamModifier;


use Tangibledesign\Framework\Search\SearchParamsModifier;

/**
 * Class LimitSearchParamModifier
 * @package Tangibledesign\Framework\Search\SearchParamModifier
 */
class LimitSearchParamModifier implements SearchParamsModifier
{
    /**
     * @param array $queryArgs
     * @param array $params
     * @return array
     */
    public function applyParams(array $queryArgs, array $params): array
    {
        if (isset($params['limit'])) {
            $queryArgs['posts_per_page'] = (int)$params['limit'];
        }

        return $queryArgs;
    }

}