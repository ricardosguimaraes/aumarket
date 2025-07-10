<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetGoogleAuth
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetGoogleAuth
{
    use Setting;

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setGoogleAuth($enabled): void
    {
        $this->setSetting(SettingKey::GOOGLE_AUTH, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function googleAuth(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::GOOGLE_AUTH));
    }

    /**
     * @param string $clientId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setGoogleAuthClientId($clientId): void
    {
        $this->setSetting(SettingKey::GOOGLE_AUTH_CLIENT_ID, $clientId);
    }

    /**
     * @return string
     */
    public function getGoogleAuthClientId(): string
    {
        return (string)$this->getSetting(SettingKey::GOOGLE_AUTH_CLIENT_ID);
    }

    /**
     * @param string $clientSecret
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setGoogleAuthClientSecret($clientSecret): void
    {
        $this->setSetting(SettingKey::GOOGLE_AUTH_CLIENT_SECRET, $clientSecret);
    }

    /**
     * @return string
     */
    public function getGoogleAuthClientSecret(): string
    {
        return (string)$this->getSetting(SettingKey::GOOGLE_AUTH_CLIENT_SECRET);
    }

    /**
     * @return bool
     */
    public function showGoogleAuth(): bool
    {
        return $this->googleAuth()
            && !empty($this->getGoogleAuthClientId())
            && !empty($this->getGoogleAuthClientSecret());
    }

}