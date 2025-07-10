<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Presentation;

use Tangibledesign\Framework\Models\Field\Helpers\HasDisplayValueWithFieldNameInterface;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Model;

class AdQuickPreview
{
    /**
     * @var Model
     */
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

            $displayLabel = $field instanceof HasDisplayValueWithFieldNameInterface ? $field->displayValueWithFieldName() : true;
//
//            /** @noinspection SlowArrayOperationsInLoopInspection */
//            $attributes = array_merge(
//                $attributes,
//                $field->getSimpleTextValue($this->model, apply_filters(tdf_prefix() . '/listingCard/showAttributeLabel', $displayLabel))
//            );

            foreach ($field->getSimpleTextValue($this->model, apply_filters(tdf_prefix() . '/listingCard/showAttributeLabel', $displayLabel)) as $value) {
                $attributes[] = [
                    'icon' => $fieldData['icon'],
                    'value' => $value,
                ];
            }
        }

        return $attributes;
    }

    public function getCategories(): array
    {
        $categories = [];

        foreach (tdf_app('card_quick_view_category_fields') as $field) {
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