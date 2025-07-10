<?php


namespace Tangibledesign\Framework\Search\SearchParamModifier;


use Tangibledesign\Framework\Search\SearchParamsModifier;
use Tangibledesign\Framework\Search\SearchUrlModifier;

/**
 * Class OffsetSearchParamModifier
 * @package Tangibledesign\Framework\Search\SearchParamModifier
 */
class OffsetSearchParamModifier implements SearchParamsModifier, SearchUrlModifier
{
    /**
     * @param array $queryArgs
     * @param array $params
     * @return array
     */
    public function applyParams(array $queryArgs, array $params): array
    {
        if (isset($params['page'])) {
            $queryArgs['paged'] = (int)$params['page'];
        }

        if (isset($params[tdf_slug('pagination')])) {
            $queryArgs['paged'] = (int)$params[tdf_slug('pagination')];
        }

        return $queryArgs;
    }

    /**
     * @param array $filters
     * @param array $params
     * @return string
     */
    public function geSearchUrlPartials(array $filters, array $params): string
    {
        if (isset($params['page'])) {
            return tdf_slug('pagination') . '=' . (int)$params['page'];
        }

        if (isset($params[tdf_slug('pagination')])) {
            return tdf_slug('pagination') . '=' . (int)$params[tdf_slug('pagination')];
        }

        return '';
    }

}