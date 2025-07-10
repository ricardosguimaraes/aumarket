<?php


namespace Tangibledesign\Framework\Core\Settings;


use Tangibledesign\Framework\Models\Field\Field;

/**
 * Trait SetFieldsOrder
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetFieldsOrder
{
    use Setting;

    /**
     * @param array $fieldsIds
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setFieldsOrder($fieldsIds): void
    {
        $this->setSetting(SettingKey::FIELDS_ORDER, $fieldsIds);
    }

    /**
     * @param int $fieldId
     * @return void
     */
    public function addField(int $fieldId): void
    {
        $fieldIds = $this->getFieldsOrder();

        $fieldIds[] = $fieldId;

        $this->setFieldsOrder($fieldIds);

        tdf_settings()->save();
    }

    /**
     * @return array
     */
    public function getFieldsOrder(): array
    {
        $fieldsIds = $this->getSetting(SettingKey::FIELDS_ORDER);

        if (!is_array($fieldsIds)) {
            return tdf_fields()
                ->map(static function ($field) {
                    if (!$field instanceof Field) {
                        return false;
                    }

                    return $field->getId();
                })
                ->filter(static function ($fieldId) {
                    return $fieldId !== false && $fieldId !== null;
                })
                ->values();
        }

        return tdf_collect($fieldsIds)->map(static function ($id) {
            return (int)$id;
        })->values();
    }

}