<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Presentation;

use Tangibledesign\Framework\Models\Field\Helpers\HasDisplayValueWithFieldNameInterface;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Model;

class AdCard
{
    /** @var Model */
    protected $model;

    /** @var bool */
    private $showFeatured;

    public function __construct(Model $model, array $settings = [])
    {
        $this->model = $model;

        $this->showFeatured = empty($settings['hide_featured']);
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
        return $this->getAttributeData('card_attribute_fields');
    }

    public function getRowAttributes(): array
    {
        return $this->getAttributeData('row_attribute_fields');
    }

    private function getAttributeData(string $attributeType): array
    {
        $attributes = tdf_collect();

        foreach (tdf_app($attributeType) as $fieldData) {
            $displayLabel = !$fieldData['field'] instanceof HasDisplayValueWithFieldNameInterface || $fieldData['field']->displayValueWithFieldName();

            $attributes[] = [
                'icon' => $fieldData['icon'],
                'values' => $fieldData['field']->getSimpleTextValue(
                    $this->model,
                    apply_filters(tdf_prefix().'/listingCard/showAttributeLabel', $displayLabel)
                )
            ];
        }

        return $attributes->filter(static function ($attribute) {
            return !empty($attribute['values']);
        })->values();
    }

    public function showFeatured(): bool
    {
        return $this->showFeatured;
    }
}