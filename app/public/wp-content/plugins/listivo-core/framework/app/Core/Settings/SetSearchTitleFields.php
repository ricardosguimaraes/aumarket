<?php

namespace Tangibledesign\Framework\Core\Settings;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

trait SetSearchTitleFields
{
    use Setting;

    /**
     * @param array $fieldIds
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setSearchTitleFields($fieldIds): void
    {
        $this->setSetting(SettingKey::SEARCH_TITLE_FIELDS, $fieldIds);
    }

    public function getSearchTitleFieldIds(): array
    {
        $fieldIds = $this->getSetting(SettingKey::SEARCH_TITLE_FIELDS);
        if (empty($fieldIds) || !is_array($fieldIds)) {
            return [];
        }

        return tdf_collect($fieldIds)
            ->map(static function ($fieldId) {
                return (int)$fieldId;
            })
            ->values();
    }

    /**
     * @return Collection|TaxonomyField[]
     */
    public function getSearchTitleFields(): Collection
    {
        return tdf_collect($this->getSearchTitleFieldIds())
            ->map(static function ($fieldId) {
                return tdf_taxonomy_fields()->find(static function ($taxonomyField) use ($fieldId) {
                    /* @var TaxonomyField $taxonomyField */
                    return $taxonomyField->getId() === $fieldId;
                });
            })
            ->filter(static function ($taxonomyField) {
                return $taxonomyField instanceof TaxonomyField;
            });
    }

    /**
     * @param array $fieldIds
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setSecondSearchTitleFields($fieldIds): void
    {
        $this->setSetting(SettingKey::SECOND_SEARCH_TITLE_FIELDS, $fieldIds);
    }

    public function getSearchTitleFieldIds2(): array
    {
        $fieldIds = $this->getSetting(SettingKey::SECOND_SEARCH_TITLE_FIELDS);
        if (empty($fieldIds) || !is_array($fieldIds)) {
            return [];
        }

        return tdf_collect($fieldIds)
            ->map(static function ($fieldId) {
                return (int)$fieldId;
            })
            ->values();
    }

    /**
     * @return Collection|TaxonomyField[]
     */
    public function getSearchTitleFields2(): Collection
    {
        return tdf_collect($this->getSearchTitleFieldIds2())
            ->map(static function ($fieldId) {
                return tdf_taxonomy_fields()
                    ->find(static function ($taxonomyField) use ($fieldId) {
                        /* @var TaxonomyField $taxonomyField */
                        return $taxonomyField->getId() === $fieldId;
                    });
            })
            ->filter(static function ($taxonomyField) {
                return $taxonomyField instanceof TaxonomyField;
            });
    }
}