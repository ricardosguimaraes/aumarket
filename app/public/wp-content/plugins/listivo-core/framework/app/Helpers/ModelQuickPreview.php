<?php

namespace Tangibledesign\Framework\Helpers;

use Tangibledesign\Framework\Models\Field\Helpers\HasDisplayValueWithFieldNameInterface;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Model;

class ModelQuickPreview
{
    /* @var Model */
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getMainValue(): string
    {
        foreach (tdf_app('card_main_value_fields') as $mainValueField) {
            /* @var PriceField|SalaryField $mainValueField */
            $value = $mainValueField->getValueByCurrency($this->model);
            if (!empty($value)) {
                return $value;
            }
        }

        return '';
    }

    public function getAttributes(): array
    {
        $attributes = [];

        foreach (tdf_app('card_quick_view_attribute_fields') as $fieldData) {
            $field = $fieldData['field'];

            foreach ($field->getSimpleTextValue($this->model) as $value) {
                $fieldData['value'] = $value;

                $attributes[] = $fieldData;
            }
        }

        return array_filter($attributes, static fn($attribute) => !empty($attribute['value']));
    }

    public function getCategories(): array
    {
        $categories = [];

        foreach (tdf_app('card_quick_view_category_fields') as $field) {
            if ($field === 'featured') {
                if (!$this->model->isFeatured()) {
                    continue;
                }

                $categories[] = tdf_string('featured');

                continue;
            }

            $displayLabel = $field instanceof HasDisplayValueWithFieldNameInterface ? $field->displayValueWithFieldName() : true;

            /** @noinspection SlowArrayOperationsInLoopInspection */
            $categories = array_merge(
                $categories,
                $field->getSimpleTextValue($this->model, apply_filters(tdf_prefix() . '/listingCard/showAttributeLabel', $displayLabel))
            );
        }

        return $categories;
    }
}