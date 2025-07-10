<?php


namespace Tangibledesign\Framework\Search\Query;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Currency;
use Tangibledesign\Framework\Search\Field\PriceSearchField;
use Tangibledesign\Framework\Search\Helpers\QueryModels;
use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;
use Tangibledesign\Framework\Search\SearchResultsModifier;
use Tangibledesign\Framework\Search\SearchUrlModifier;
use Tangibledesign\Framework\Models\Field\PriceField;

/**
 * Class PriceQuery
 * @package Tangibledesign\Framework\Search\QueryModifier
 */
class PriceQueryModifier extends QueryModifier implements SearchUrlModifier, SearchResultsModifier
{
    use QueryModels;

    /**
     * @var PriceField
     */
    private $field;

    /**
     * PriceQuery constructor.
     * @param PriceField $priceField
     */
    public function __construct(PriceField $priceField)
    {
        $this->field = $priceField;
    }

    /**
     * @param array $filters
     * @param array $params
     * @return string
     */
    public function geSearchUrlPartials(array $filters, array $params): string
    {
        $urlPartials = [];

        foreach ($this->getKeys() as $key) {
            $filter = $this->getFilter($key, $filters);
            if (!$filter || empty($filter['values']) || empty($filter['values'][0])) {
                continue;
            }

            $urlPartials[] = $this->getUrlPartial($this->field->getSlug(), $filter['values'][0], $filter['compareType']);
        }

        return tdf_collect($urlPartials)->filter(static function ($urlPartial) {
            return $urlPartial !== '';
        })->implode('&');
    }

    /**
     * @param string $slug
     * @param string $value
     * @param string $compareType
     * @return string
     */
    private function getUrlPartial(string $slug, string $value, string $compareType): string
    {
        if (empty($value)) {
            return '';
        }

        if ($compareType === PriceSearchField::COMPARE_TYPE_GREATER) {
            return $slug . tdf_slug('-from') . '=' . $value;
        }

        if ($compareType === PriceSearchField::COMPARE_TYPE_LESS) {
            return $slug . tdf_slug('-to') . '=' . $value;
        }

        return $slug . '=' . $value;
    }

    /**
     * @return array
     */
    private function getKeys(): array
    {
        $fieldKey = $this->field->getKey();

        return [
            $fieldKey,
            $fieldKey . '_from',
            $fieldKey . '_to',
        ];
    }

    /**
     * @param string $postType
     * @param array $filters
     * @return int[]|false
     */
    public function getModelIds(string $postType, array $filters)
    {
        $currency = tdf_app('current_currency');
        if (!$currency instanceof Currency) {
            return false;
        }

        $allIds = tdf_collect([
            $this->getModelIdsMixed($postType, $filters, $currency->getKey()),
            $this->getModelIdsFrom($postType, $filters, $currency->getKey()),
            $this->getModelIdsTo($postType, $filters, $currency->getKey()),
        ])->filter(static function ($ids) {
            return $ids !== false;
        });

        if ($allIds->isEmpty()) {
            return false;
        }

        return $this->mergeModelIds($allIds);
    }


    /**
     * @param Collection $modelIds
     * @return array|false
     */
    private function mergeModelIds(Collection $modelIds)
    {
        $output = false;

        foreach ($modelIds as $ids) {
            if ($output === false) {
                $output = $ids;
            } else {
                $output = array_intersect($output, $ids);
            }
        }

        return $output;
    }

    /**
     * @param string $postType
     * @param array $filters
     * @param string $currencyKey
     * @return array|false
     */
    private function getModelIdsMixed(string $postType, array $filters, string $currencyKey)
    {
        $filter = $this->getFilter($this->field->getKey(), $filters);
        if (!$filter || empty($filter['values']) || empty($filter['values'][0])) {
            return false;
        }

        $modelIds = false;

        foreach ($filter['values'] as $value) {
            $ids = $this->metaQueryModels($postType, [
                'key' => $this->field->getKey() . '_' . $currencyKey,
                'value' => $value,
                'compare' => $this->getCompareOperator($filter['compareType']),
                'type' => 'DECIMAL',
            ]);

            if ($modelIds === false) {
                $modelIds = $ids;
            } else {
                $modelIds = array_intersect($modelIds, $ids);
            }
        }

        return $modelIds;
    }

    /**
     * @param string $postType
     * @param array $filters
     * @param string $currencyKey
     * @return array|false
     */
    private function getModelIdsFrom(string $postType, array $filters, string $currencyKey)
    {
        $filter = $this->getFilter($this->field->getKey() . '_from', $filters);
        if (!$filter || empty($filter['values'])) {
            return false;
        }

        return $this->metaQueryModels($postType, [
            'key' => $this->field->getKey() . '_' . $currencyKey,
            'compare' => '>=',
            'value' => $filter['values'][0],
            'type' => 'DECIMAL',
        ]);
    }

    /**
     * @param string $postType
     * @param array $filters
     * @param string $currencyKey
     * @return array|false
     */
    private function getModelIdsTo(string $postType, array $filters, string $currencyKey)
    {
        $filter = $this->getFilter($this->field->getKey() . '_to', $filters);
        if (!$filter) {
            return false;
        }

        return $this->metaQueryModels($postType, [
            'key' => $this->field->getKey() . '_' . $currencyKey,
            'compare' => '<=',
            'value' => $filter['values'][0],
            'type' => 'DECIMAL',
        ]);
    }

    /**
     * @param string $compareType
     * @return string
     */
    private function getCompareOperator(string $compareType): string
    {
        if ($compareType === PriceSearchField::COMPARE_TYPE_GREATER) {
            return '>=';
        }

        if ($compareType === PriceSearchField::COMPARE_TYPE_LESS) {
            return '<=';
        }

        return '=';
    }

    /**
     * @return array
     * @noinspection DuplicatedCode
     */
    public function getFiltersFromUrl(): array
    {
        $filters = [];

        foreach ($this->getParams() as $param) {
            if (!isset($_GET[$param['slug']]) || empty($_GET[$param['slug']])) {
                continue;
            }

            $filters[] = [
                'key' => $param['key'],
                'compareType' => $param['compare'],
                'values' => [
                    $_GET[$param['slug']]
                ],
                'label' => $this->getSearchFilterLabel($_GET[$param['slug']], $param['compare']),
                'type' => 'regular',
            ];
        }

        return $filters;
    }

    /**
     * @param $value
     * @param $compare
     * @return string
     */
    private function getSearchFilterLabel($value, $compare): string
    {
        if (empty($value)) {
            return '';
        }

        $label = tdf_current_currency()->format($value);

        if ($this->field->getTextBeforeValue() !== '') {
            $label = $this->field->getTextBeforeValue() . ' ' . $label;
        }

        if ($this->field->getTextAfterValue() !== '') {
            $label .= ' ' . $this->field->getTextAfterValue();
        }

        if ($compare === 'greater') {
            $label = '> ' . $label;
        }

        if ($compare === 'less') {
            $label = '< ' . $label;
        }

        return $label;
    }

    /**
     * @return array[]
     * @noinspection DuplicatedCode
     */
    private function getParams(): array
    {
        $fieldKey = $this->field->getKey();
        $fieldSlug = $this->field->getSlug();

        return [
            [
                'key' => $fieldKey . '_from',
                'slug' => $fieldSlug . tdf_slug('-from'),
                'compare' => PriceSearchField::COMPARE_TYPE_GREATER,
            ],
            [
                'key' => $fieldKey . '_to',
                'slug' => $fieldSlug . tdf_slug('-to'),
                'compare' => PriceSearchField::COMPARE_TYPE_LESS,
            ],
        ];
    }


}