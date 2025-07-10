<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Models\Field\EmbedField;
use Tangibledesign\Framework\Models\Model;

class EmbedPanelField extends CustomPanelField
{
    /**
     * @var EmbedField
     */
    protected $field;

    /**
     * @return string
     */
    protected function getTemplate(): string
    {
        return 'embed';
    }

    /**
     * @param Model $model
     * @param array $data
     */
    public function update(Model $model, array $data = []): void
    {
        $model->setMeta($this->getKey(), $this->getValue($data));
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function getValue($data)
    {
        $attributeData = $this->getAttributeData($data);

        if (
            !$attributeData
            || !is_array($attributeData['value'])
            || !isset($attributeData['value']['embed'], $attributeData['value']['url'])
        ) {
            return [
                EmbedField::URL => '',
                EmbedField::EMBED => '',
            ];
        }

        return $attributeData['value'];
    }

    /**
     * @return bool
     */
    public function isSingleValue(): bool
    {
        return false;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (!$this->isRequired()) {
            return true;
        }

        $attribute = $this->getAttributeData($data);
        if (!$attribute) {
            return false;
        }

        if (
            !is_array($attribute['value'])
            || !isset($attribute['value']['embed'], $attribute['value']['url'])
        ) {
            return false;
        }

        return true;
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