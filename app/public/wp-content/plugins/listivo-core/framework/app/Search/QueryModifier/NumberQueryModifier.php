<?php


namespace Tangibledesign\Framework\Search\Query;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\Field\NumberSearchField;
use Tangibledesign\Framework\Search\Helpers\QueryModels;
use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;
use Tangibledesign\Framework\Search\SearchResultsModifier;
use Tangibledesign\Framework\Search\SearchUrlModifier;
use Tangibledesign\Framework\Models\Field\NumberField;

/**
 * Class NumberQueryModifier
 * @package Tangibledesign\Framework\Search\QueryModifier
 */
class NumberQueryModifier extends QueryModifier implements SearchUrlModifier, SearchResultsModifier
{
    use QueryModels;

    /**
     * @var NumberField
     */
    private $field;

    /**
     * NumberQueryModifier constructor.
     * @param NumberField $numberField
     */
    public function __construct(NumberField $numberField)
    {
        $this->field = $numberField;
    }

    /**
     * @param array $filters
     * @param array $params
     * @return string
     */
    public function geSearchUrlPartials(array $filters, array $params): string
    {
        $urlPartials = [];

        foreach ($this->getKeys() as $key => $slug) {
            $filter = $this->getFilter($key, $filters);
            if (!$filter || empty($filter['values'])) {
                continue;
            }

            foreach ($filter['values'] as $value) {
                $urlPartials[] = $this->getUrlPartial($slug, $value);
            }
        }

        return tdf_collect($urlPartials)->filter(static function ($urlPartial) {
            return $urlPartial !== '';
        })->implode('&');
    }

    /**
     * @param string $slug
     * @param string|array $value
     * @return string
     */
    private function getUrlPartial(string $slug, $value): string
    {
        if (empty($value)) {
            return '';
        }

        if (!is_array($value)) {
            return $slug . '=' . $value;
        }

        if ($value['compareType'] === NumberSearchField::COMPARE_TYPE_GREATER) {
            return $this->field->getSlug() . tdf_slug('-from') . '=' . $value['value'];
        }

        if ($value['compareType'] === NumberSearchField::COMPARE_TYPE_LESS) {
            return $this->field->getSlug() . tdf_slug('-to') . '=' . $value['value'];
        }

        return $slug . '=' . $value['value'];
    }

    /**
     * @return array
     */
    private function getKeys(): array
    {
        $fieldKey = $this->field->getKey();
        $fieldSlug = $this->field->getSlug();

        return [
            $fieldKey => $fieldSlug,
            $fieldKey . '_from' => $fieldSlug . tdf_slug('-from'),
            $fieldKey . '_to' => $fieldSlug . tdf_slug('-to'),
        ];
    }

    /**
     * @param string $postType
     * @param array $filters
     * @return int[]|false
     */
    public function getModelIds(string $postType, array $filters)
    {
        $allIds = tdf_collect([
            $this->getModelIdsMixed($postType, $filters),
            $this->getModelIdsFrom($postType, $filters),
            $this->getModelIdsTo($postType, $filters),
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
     * @return int[]|false
     */
    private function getModelIdsMixed(string $postType, array $filters)
    {
        $filter = $this->getFilter($this->field->getKey(), $filters);
        if (!$filter || empty($filter['values']) || !isset($filter['values'][0]['value'])) {
            return false;
        }

        $modelIds = false;

        foreach ($filter['values'] as $value) {
            $ids = $this->metaQueryModels($postType, [
                'key' => $this->field->getKey(),
                'value' => $value['value'],
                'compare' => $this->getCompareOperator($value['compareType']),
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
     * @return array|false
     */
    private function getModelIdsFrom(string $postType, array $filters)
    {
        $filter = $this->getFilter($this->field->getKey() . '_from', $filters);
        if (!$filter || empty($filter['values'])) {
            return false;
        }

        $value = $filter['values'][0]['value'] ?? $filter['values'][0];
        if (empty($value)) {
            return false;
        }

        return $this->metaQueryModels($postType, [
            'key' => $this->field->getKey(),
            'compare' => '>=',
            'value' => $value,
            'type' => 'DECIMAL(10, 3)',
        ]);
    }

    /**
     * @param string $postType
     * @param array $filters
     * @return array|false
     */
    private function getModelIdsTo(string $postType, array $filters)
    {
        $filter = $this->getFilter($this->field->getKey() . '_to', $filters);
        if (!$filter || empty($filter['values'])) {
            return false;
        }

        $value = $filter['values'][0]['value'] ?? $filter['values'][0];
        if (empty($value)) {
            return false;
        }

        return $this->metaQueryModels($postType, [
            'key' => $this->field->getKey(),
            'compare' => '<=',
            'value' => $value,
            'type' => 'DECIMAL(10, 3)',
        ]);
    }

    /**
     * @param string $compareType
     * @return string
     */
    private function getCompareOperator(string $compareType): string
    {
        if ($compareType === NumberSearchField::COMPARE_TYPE_GREATER) {
            return '>=';
        }

        if ($compareType === NumberSearchField::COMPARE_TYPE_LESS) {
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
                'type' => 'regular',
                'label' => $this->getSearchFilterLabel($_GET[$param['slug']], $param['compare']),
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

        $label = $value;

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

        return $this->field->getName() . ': ' . $label;
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
                'key' => $fieldKey,
                'slug' => $fieldSlug,
                'compare' => NumberSearchField::COMPARE_TYPE_EQUAL,
            ],
            [
                'key' => $fieldKey . '_from',
                'slug' => $fieldSlug . tdf_slug('-from'),
                'compare' => NumberSearchField::COMPARE_TYPE_GREATER,
            ],
            [
                'key' => $fieldKey . '_to',
                'slug' => $fieldSlug . tdf_slug('-to'),
                'compare' => NumberSearchField::COMPARE_TYPE_LESS,
            ],
        ];
    }

}