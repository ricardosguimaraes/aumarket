<?php

namespace Tangibledesign\Framework\Core\Settings;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;

trait SetModeration
{
    use Setting;

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModeration($enabled): void
    {
        $this->setSetting(SettingKey::MODERATION, (int)$enabled);
    }

    public function moderationEnabled(): bool
    {
        return !empty($this->getSetting(SettingKey::MODERATION));
    }

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModerationReApprove($enabled): void
    {
        $this->setSetting(SettingKey::MODERATION_RE_APPROVE, (int)$enabled);
    }

    public function moderationRequiredReApprove(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::MODERATION_RE_APPROVE));
    }

    public function setListingTermsAndConditions($terms): void
    {
        $this->setSetting(SettingKey::LISTING_TERMS_AND_CONDITIONS, $terms);
    }

    public function getListingTermsAndConditions(): string
    {
        return trim((string)$this->getSetting(SettingKey::LISTING_TERMS_AND_CONDITIONS));
    }

    public function setModerationPageCustomFields($customFields): void
    {
        $this->setSetting(SettingKey::MODERATION_PAGE_CUSTOM_FIELDS, $customFields);
    }

    public function getModerationPageCustomFieldsIds(): array
    {
        $fieldsIds = $this->getSetting(SettingKey::MODERATION_PAGE_CUSTOM_FIELDS);
        if (empty($fieldsIds)) {
            return [];
        }

        return tdf_collect($fieldsIds)->map(static function ($fieldId) {
            return (int)$fieldId;
        })->values();
    }

    /**
     * @return Collection|SimpleTextValue[]
     */
    public function getModerationPageCustomFields(): Collection
    {
        return tdf_collect($this->getModerationPageCustomFieldsIds())
            ->map(static function ($fieldId) {
                $fieldId = (int)$fieldId;

                return tdf_ordered_fields()->find(static function ($field) use ($fieldId) {
                    /* @var Field $field */
                    return $field->getId() === $fieldId;
                });
            })
            ->filter(static function ($field) {
                return $field instanceof SimpleTextValue;
            });
    }
}