<?php

namespace Tangibledesign\Framework\Search\Query;

use Tangibledesign\Framework\Search\Helpers\QueryModels;
use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;
use Tangibledesign\Framework\Search\SearchResultsModifier;
use Tangibledesign\Framework\Search\SearchUrlModifier;
use Tangibledesign\Framework\Models\Field\LocationField;

class LocationQueryModifier extends QueryModifier implements SearchUrlModifier, SearchResultsModifier
{
    use QueryModels;

    /**
     * @var LocationField
     */
    private $field;

    public function __construct(LocationField $locationField)
    {
        $this->field = $locationField;
    }

    public function geSearchUrlPartials(array $filters, array $params): string
    {
        $filter = $this->getFilter($this->field->getKey(), $filters);
        if (!$filter || empty($filter['values'])) {
            return '';
        }

        $slug = $this->field->getSlug();
        $value = $filter['values'][0];

        if (!isset($value['placeId'], $value['swLat'], $value['swLng'], $value['neLat'], $value['neLng'])) {
            return '';
        }

        $urlPartial = $slug . '-' . tdf_slug('place-id') . '=' . $value['placeId']
            . '&' . $slug . '-' . tdf_slug('sw-lat') . '=' . $value['swLat']
            . '&' . $slug . '-' . tdf_slug('sw-lng') . '=' . $value['swLng']
            . '&' . $slug . '-' . tdf_slug('ne-lat') . '=' . $value['neLat']
            . '&' . $slug . '-' . tdf_slug('ne-lng') . '=' . $value['neLng'];

        $radiusUrlPartial = $this->getRadiusSearchUrlPartial($filters);
        if (!empty($urlPartial) && !empty($radiusUrlPartial)) {
            $urlPartial .= '&' . $radiusUrlPartial;
        }

        return $urlPartial;
    }

    private function getRadiusSearchUrlPartial(array $filters): string
    {
        $filter = $this->getFilter($this->field->getKey() . '_radius', $filters);
        if (!$filter || empty($filter['values'])) {
            return '';
        }

        return $this->field->getSlug() . '-' . tdf_slug('radius') . '=' . $filter['values'][0];
    }

    /**
     * @param string $postType
     * @param array $filters
     * @return array|false
     */
    public function getModelIds(string $postType, array $filters)
    {
        $filter = $this->getFilter($this->field->getKey(), $filters);
        if (!$filter || empty($filter['values'])) {
            return false;
        }

        $value = $filter['values'][0];
        if (!isset($value['swLat'], $value['swLng'], $value['neLat'], $value['neLng'])) {
            return false;
        }

        return $this->queryModels($postType, [
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => $this->field->getKey() . '_' . LocationField::LAT,
                    'compare' => 'BETWEEN',
                    'value' => [(double)$value['swLat'], (double)$value['neLat']],
                    'type' => 'DECIMAL(5,2)',
                ],
                [
                    'key' => $this->field->getKey() . '_' . LocationField::LNG,
                    'compare' => 'BETWEEN',
                    'value' => [(double)$value['swLng'], (double)$value['neLng']],
                    'type' => 'DECIMAL(5,2)',
                ],
            ]
        ]);
    }

    public function getFiltersFromUrl(): array
    {
        $value = [];

        foreach ($this->getParams() as $key => $slug) {
            if (empty($_GET[$slug])) {
                return [];
            }

            $value[$key] = $_GET[$slug];
        }

        $filters = [
            [
                'key' => $this->field->getKey(),
                'values' => [$value],
            ]
        ];

        $radiusFilter = $this->getRadiusFilter();
        if ($radiusFilter) {
            $filters[] = $radiusFilter;
        }

        return $filters;
    }

    private function getRadiusFilter(): array
    {
        $slug = $this->field->getSlug() . '-' . tdf_slug('radius');
        if (empty($_GET[$slug])) {
            return $this->getDefaultRadiusFilter();
        }

        $radius = (int)$_GET[$slug];
        if (empty($radius)) {
            return $this->getDefaultRadiusFilter();
        }

        return [
            'key' => $this->field->getKey() . '_radius',
            'values' => [$radius],
            'type' => 'radius',
        ];
    }

    private function getDefaultRadiusFilter(): array
    {
        return [
            'key' => $this->field->getKey() . '_radius',
            'values' => [tdf_settings()->getDefaultMapRadiusValue()],
            'type' => 'radius',
        ];
    }

    private function getParams(): array
    {
        $fieldSlug = $this->field->getSlug();

        return [
            'placeId' => $fieldSlug . '-' . tdf_slug('place-id'),
            'swLat' => $fieldSlug . '-' . tdf_slug('sw-lat'),
            'swLng' => $fieldSlug . '-' . tdf_slug('sw-lng'),
            'neLat' => $fieldSlug . '-' . tdf_slug('ne-lat'),
            'neLng' => $fieldSlug . '-' . tdf_slug('ne-lng'),
        ];
    }
}