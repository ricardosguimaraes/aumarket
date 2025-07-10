<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetExcludeFromSearch
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetExcludeFromSearch
{
    use Setting;

    /**
     * @param array $terms
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setExcludeFromSearch($terms): void
    {
        $this->setSetting(SettingKey::EXCLUDE_FROM_SEARCH, $terms);
    }

    /**
     * @return array
     */
    public function getExcludedFromSearchTermIds(): array
    {
        $termIds = $this->getSetting(SettingKey::EXCLUDE_FROM_SEARCH);
        if (!is_array($termIds)) {
            return [];
        }

        return tdf_collect($termIds)->map(static function ($termId) {
            return (int)$termId;
        })->values();
    }

}