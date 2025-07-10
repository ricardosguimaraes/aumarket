<?php

namespace Tangibledesign\Framework\Search\SearchParamModifier;

use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Search\SearchParamsModifier;
use Tangibledesign\Framework\Search\SearchUrlModifier;

class SortSearchParamModifier implements SearchParamsModifier, SearchUrlModifier
{
    public function applyParams(array $queryArgs, array $params): array
    {
        $orderBy = tdf_slug('newest');

        if (isset($params[tdf_slug('sort-by')])) {
            $orderBy = $params[tdf_slug('sort-by')];
        } elseif (isset($params['sortBy'])) {
            $orderBy = $params['sortBy'];
        }

        if ($orderBy === tdf_slug('newest')) {
            return $this->orderByNewest($queryArgs);
        }

        if ($orderBy === tdf_slug('oldest')) {
            return $this->orderByOldest($queryArgs);
        }

        if ($orderBy === tdf_slug('most_relevant')) {
            return $this->orderByFeatured($queryArgs);
        }

        if ($orderBy === tdf_slug('name_asc')) {
            return $this->orderByNameAsc($queryArgs);
        }

        if ($orderBy === 'random') {
            return $this->orderByRandom($queryArgs);
        }

        foreach (tdf_price_fields() as $priceField) {
            if ($orderBy === $priceField->getSlug() . '-' . tdf_slug('high_to_low')) {
                return $this->orderByPrice($priceField, $queryArgs, 'DESC');
            }

            if ($orderBy === $priceField->getSlug() . '-' . tdf_slug('low_to_high')) {
                return $this->orderByPrice($priceField, $queryArgs);
            }
        }

        foreach (tdf_number_fields() as $numberField) {
            if ($orderBy === $numberField->getSlug() . '-' . tdf_slug('high_to_low')) {
                return $this->orderByNumberField($numberField, $queryArgs, 'DESC');
            }

            if ($orderBy === $numberField->getSlug() . '-' . tdf_slug('low_to_high')) {
                return $this->orderByNumberField($numberField, $queryArgs);
            }
        }

        return $this->orderByNewest($queryArgs);
    }

    private function orderByRandom(array $queryArgs): array
    {
        $queryArgs['orderby'] = 'rand';

        return $queryArgs;
    }

    private function orderByPrice(PriceField $priceField, array $queryArgs, string $order = 'ASC'): array
    {
        if (!tdf_current_currency()) {
            return $queryArgs;
        }

        /** @noinspection NullPointerExceptionInspection */
        $priceKey = $priceField->getKey() . '_' . tdf_current_currency()->getKey();

        $queryArgs['orderby'] = 'meta_value_num';
        $queryArgs['order'] = $order;
        $queryArgs['meta_key'] = $priceKey;
        $queryArgs['meta_type'] = 'NUMERIC';
        $queryArgs['meta_query'] = [
            'relation' => 'OR',
            [
                'key' => $priceKey,
                'compare' => 'EXISTS'
            ],
            [
                'key' => $priceKey,
                'compare' => 'NOT EXISTS',
                'value' => ''
            ]
        ];

        return $queryArgs;
    }

    private function orderByNumberField(NumberField $numberField, array $queryArgs, string $order = 'ASC'): array
    {
        $queryArgs['orderby'] = [
            'meta_value_num' => $order
        ];

        $queryArgs['meta_key'] = $numberField->getKey();

        $queryArgs['meta_query'] = [
            'relation' => 'OR',
            [
                'key' => $numberField->getKey(),
                'compare' => 'EXISTS'
            ],
            [
                'key' => $numberField->getKey(),
                'compare' => 'NOT EXISTS',
                'value' => ''
            ]
        ];

        return $queryArgs;
    }

    private function orderByNewest(array $queryArgs): array
    {
        $queryArgs['orderby'] = ['date' => 'DESC', 'ID' => 'DESC'];

        return $queryArgs;
    }

    private function orderByOldest(array $queryArgs): array
    {
        $queryArgs['orderby'] = 'date';
        $queryArgs['order'] = 'ASC';

        return $queryArgs;
    }

    private function orderByFeatured(array $queryArgs): array
    {
        $queryArgs['meta_key'] = 'featured';
        $queryArgs['orderby'] = [
            'meta_value_num' => 'DESC',
            'date' => 'DESC',
            'ID' => 'DESC'
        ];

        return $queryArgs;
    }

    private function orderByNameAsc(array $queryArgs): array
    {
        $queryArgs['orderby'] = [
            'title' => 'ASC',
            'date' => 'DESC',
            'ID' => 'DESC'
        ];

        return $queryArgs;
    }

    public function geSearchUrlPartials(array $filters, array $params): string
    {
        if (isset($params[tdf_slug('sort-by')])) {
            return tdf_slug('sort-by') . '=' . $params[tdf_slug('sort-by')];
        }

        if (isset($params['sortBy'])) {
            return tdf_slug('sort-by') . '=' . $params['sortBy'];
        }

        return '';
    }
}