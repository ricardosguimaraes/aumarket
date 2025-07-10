<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Model;

class PricePanelField extends CustomPanelField
{
    /**
     * @var PriceField
     */
    protected $field;

    protected function getTemplate(): string
    {
        return 'price';
    }

    public function update(Model $model, array $data = []): void
    {
        $attribute = $this->getAttributeData($data);
        $field = $this->getField();

        /* @var PriceField $field */
        $field->setValue($model, $attribute['value'] ?? '');
    }

    public function isSingleValue(): bool
    {
        return true;
    }

    public function validate(array $data): bool
    {
        if (!$this->isRequired()) {
            return true;
        }

        $attribute = $this->getAttributeData($data);

        return $attribute && !empty($attribute['value']);
    }

    public function getModelAttribute(Model $model)
    {
        return [
            'id' => $this->field->getId(),
            'value' => $this->field->getValuesForFrontendEditor($model),
        ];
    }

}