<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Models\Field\LinkField;
use Tangibledesign\Framework\Models\Model;

class LinkPanelField extends CustomPanelField
{
    protected function getTemplate(): string
    {
        return 'link';
    }

    public function update(Model $model, array $data = []): void
    {
        $attribute = $this->getAttributeData($data);
        $field = $this->getField();

        /* @var LinkField $field */
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