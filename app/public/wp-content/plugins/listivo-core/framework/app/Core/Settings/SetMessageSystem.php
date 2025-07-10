<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetMessageSystem
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetMessageSystem
{
    use Setting;

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMessageSystem($enabled): void
    {
        $this->setSetting(SettingKey::MESSAGE_SYSTEM, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function messageSystem(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::MESSAGE_SYSTEM));
    }

}