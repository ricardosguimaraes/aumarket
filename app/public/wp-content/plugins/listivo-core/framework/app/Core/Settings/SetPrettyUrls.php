<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetPrettyUrls
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetPrettyUrls
{
    use Setting;

    /**
     * @param int $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setPrettyUrls($enable): void
    {
        $this->setSetting(SettingKey::PRETTY_URLS, !empty($enable));
    }

    /**
     * @return bool
     */
    public function prettyUrls(): bool
    {
        return !empty($this->getSetting(SettingKey::PRETTY_URLS));
    }

}