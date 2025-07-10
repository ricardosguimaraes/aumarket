<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Model;


class LocationPanelField extends CustomPanelField
{
    /**
     * @var LocationField
     */
    protected $field;

    /**
     * @return string
     */
    protected function getTemplate(): string
    {
        return 'location';
    }

    /**
     * @param Model $model
     * @param array $data
     */
    public function update(Model $model, array $data = []): void
    {
        $this->field->setValue($model, $this->getValue($data));
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
     * @return bool
     */
    public function validate(array $data): bool
    {
        if (!$this->isRequired()) {
            return true;
        }

        $attribute = $this->getAttributeData($data);

        if (!$attribute || empty($attribute['value'])) {
            return false;
        }

        return !empty($attribute['value']['address']);
    }

    /**
     * @param array $data
     * @return array|string
     */
    private function getValue(array $data)
    {
        $attributeData = $this->getAttributeData($data);

        if (!$attributeData || !isset($attributeData['value'])) {
            return '';
        }

        return $attributeData['value'];
    }

    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();

        $data['countries'] = $this->field->getRestrictedCountries();
        $data['inputType'] = $this->field->getInputType();

        return $data;
    }

    /**
     * @param Model $model
     * @return mixed
     */
    public function getModelAttribute(Model $model)
    {
        $value = $this->field->getValue($model);

        return [
            'id' => $this->field->getId(),
            'value' => [
                'address' => $value['address'],
                'lat' => $value['location']['lat'] ?? '',
                'lng' => $value['location']['lng'] ?? '',
            ]
        ];
    }

}