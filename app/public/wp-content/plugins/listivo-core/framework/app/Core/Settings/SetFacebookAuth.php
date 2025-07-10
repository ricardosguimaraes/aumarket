<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetFacebookAuth
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetFacebookAuth
{
    use Setting;

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setFacebookAuth($enabled): void
    {
        $this->setSetting(SettingKey::FACEBOOK_AUTH, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function facebookAuth(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::FACEBOOK_AUTH));
    }

    /**
     * @param string $appId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setFacebookAuthAppId($appId): void
    {
        $this->setSetting(SettingKey::FACEBOOK_AUTH_APP_ID, $appId);
    }

    /**
     * @return string
     */
    public function getFacebookAuthAppId(): string
    {
        return (string)$this->getSetting(SettingKey::FACEBOOK_AUTH_APP_ID);
    }

    /**
     * @param string $appSecret
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setFacebookAuthAppSecret($appSecret): void
    {
        $this->setSetting(SettingKey::FACEBOOK_AUTH_APP_SECRET, $appSecret);
    }

    /**
     * @return string
     */
    public function getFacebookAuthAppSecret(): string
    {
        return (string)$this->getSetting(SettingKey::FACEBOOK_AUTH_APP_SECRET);
    }

    /**
     * @return bool
     */
    public function showFacebookAuth(): bool
    {
        return $this->facebookAuth()
            && !empty($this->getFacebookAuthAppId())
            && !empty($this->getFacebookAuthAppSecret());
    }

}