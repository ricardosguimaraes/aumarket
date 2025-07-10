<?php

namespace Tangibledesign\Framework\Core\Settings;

use Tangibledesign\Framework\Models\Field\TaxonomyField;

trait SetMainCategory
{
    use Setting;

    /**
     * @param int $taxonomyFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMainCategory($taxonomyFieldId): void
    {
        $this->setSetting(SettingKey::MAIN_CATEGORY, (int)$taxonomyFieldId);
    }

    /**
     * @return int
     */
    public function getMainCategoryId(): int
    {
        return (int)$this->getSetting(SettingKey::MAIN_CATEGORY);
    }

    /**
     * @return TaxonomyField|false
     */
    public function getMainCategory()
    {
        $mainCategoryId = $this->getMainCategoryId();

        return tdf_taxonomy_fields()->find(static function ($taxonomy) use ($mainCategoryId) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getId() === $mainCategoryId;
        });
    }

}