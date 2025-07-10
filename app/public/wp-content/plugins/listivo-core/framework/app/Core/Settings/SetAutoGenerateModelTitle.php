<?php

namespace Tangibledesign\Framework\Core\Settings;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;

trait SetAutoGenerateModelTitle
{
    use Setting;

    /**
     * @param array $fieldIds
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAutoGenerateModelTitle($fieldIds): void
    {
        $this->setSetting(SettingKey::AUTO_GENERATE_MODEL_TITLE, $fieldIds);
    }

    /**
     * @return Collection
     */
    public function getAutoGenerateModelTitleFieldIds(): Collection
    {
        $fieldIds = $this->getSetting(SettingKey::AUTO_GENERATE_MODEL_TITLE);
        if (!is_array($fieldIds)) {
            return tdf_collect();
        }

        return tdf_collect($fieldIds)->map(static function ($fieldId) {
            return (int)$fieldId;
        });
    }

    /**
     * @return Collection|SimpleTextValue[]
     */
    public function getAutoGenerateModelTitleFields(): Collection
    {
        return $this->getAutoGenerateModelTitleFieldIds()->map(static function ($fieldId) {
            return tdf_simple_text_value_fields()->find(static function ($field) use ($fieldId) {
                /* @var Field $field */
                return $field->getId() === $fieldId;
            });
        })->filter(static function ($field) {
            return $field !== false && $field !== null;
        });
    }

    /**
     * @return Collection|Field[]
     */
    public function getNotAutoGenerateModelTitleFields(): Collection
    {
        $selectedIds = $this->getAutoGenerateModelTitleFieldIds()->values();

        return tdf_simple_text_value_fields()->filter(static function ($field) use ($selectedIds) {
            /* @var SimpleTextValue $field */
            return !in_array($field->getId(), $selectedIds, true);
        });
    }
}