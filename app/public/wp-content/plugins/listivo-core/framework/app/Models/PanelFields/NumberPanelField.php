<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Model;

class NumberPanelField extends CustomPanelField
{
    /* @var NumberField $field */
    protected $field;

    /**
     * @return string
     */
    protected function getTemplate(): string
    {
        return 'number';
    }

    /**
     * @param Model $model
     * @param array $data
     */
    public function update(Model $model, array $data = []): void
    {
        $attribute = $this->getAttributeData($data);
        $field = $this->getField();

        /* @var NumberField $field */
        $field->setValue($model, $attribute['value'] ?? '');
    }

    /**
     * @return bool
     */
    public function isSingleValue(): bool
    {
        return true;
    }

    /**
     * @param array $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (!$this->isRequired()) {
            return true;
        }

        $attribute = $this->getAttributeData($data);

        return $attribute && isset($attribute['value']) && $attribute['value'] !== '';
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function getModelAttribute(Model $model)
    {
        return [
            'id' => $this->field->getId(),
            'value' => $this->field->getValue($model),
        ];
    }

}