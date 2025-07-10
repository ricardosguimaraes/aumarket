<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetFavorite
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetFavorite
{
    use Setting;

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setFavorite($enabled): void
    {
        $this->setSetting(SettingKey::FAVORITE, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function isFavoriteEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::FAVORITE));
    }

}