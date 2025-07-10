<?php

namespace Tangibledesign\Framework\Search\Query;

use Tangibledesign\Framework\Search\Helpers\QueryModels;
use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;
use Tangibledesign\Framework\Search\SearchResultsModifier;
use Tangibledesign\Framework\Search\SearchUrlModifier;
use Tangibledesign\Framework\Models\Field\TextField;

class TextQueryModifier extends QueryModifier implements SearchUrlModifier, SearchResultsModifier
{
    use QueryModels;

    /**
     * @var TextField
     */
    private $field;

    public function __construct(TextField $field)
    {
        $this->field = $field;
    }

    public function geSearchUrlPartials(array $filters, array $params): string
    {
        $filter = $this->getFilter($this->field->getKey(), $filters);
        if (!$filter) {
            return '';
        }

        $urlValue = $this->getUrlValue($filter);
        if (empty($urlValue)) {
            return '';
        }

        return $this->field->getSlug() . '=' . $urlValue;
    }

    private function getUrlValue(array $filter): string
    {
        return implode('', $filter['values']);
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

        return $this->metaQueryModels($postType, [
            'key' => $this->field->getKey(),
            'value' => $filter['values'][0],
            'compare' => $this->field->getCompareLogic() === TextField::COMPARE_LOGIC_LIKE ? 'LIKE' : '=',
        ]);
    }

    public function getFiltersFromUrl(): array
    {
        $slug = $this->field->getSlug();
        if (empty($_GET[$slug])) {
            return [];
        }

        return [
            [
                'key' => $this->field->getKey(),
                'values' => [$_GET[$slug]],
                'type' => 'regular',
                'label' => $_GET[$slug],
            ]
        ];
    }
}