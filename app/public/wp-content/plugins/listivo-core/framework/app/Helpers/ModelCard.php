<?php

namespace Tangibledesign\Framework\Helpers;

use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Model;

class ModelCard
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
            $values = $fieldData['field']->getSimpleTextValue($this->model);

            foreach ($values as $value) {
                if (empty($value)) {
                    continue;
                }

                $attributes[] = [
                    'icon' => $fieldData['icon'],
                    'text_before' => $fieldData['text_before'] ?? '',
                    'value' => $value,
                    'text_after' => $fieldData['text_after'] ?? '',
                ];
            }
        }

        return $attributes->values();
    }

    public function showFeatured(): bool
    {
        return $this->showFeatured;
    }
}