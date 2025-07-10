<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetSocialMedia
{
    use Setting;

    public function setFacebookApiKey($apiKey): void
    {
        $this->setSetting(SettingKey::FACEBOOK_API_KEY, $apiKey);
    }

    public function getFacebookApiKey(): string
    {
        return (string)$this->getSetting(SettingKey::FACEBOOK_API_KEY);
    }

    public function setFacebookProfile($profile): void
    {
        $this->setSetting(SettingKey::FACEBOOK_PROFILE, $profile);
    }

    public function getFacebookProfile(): string
    {
        return (string)$this->getSetting(SettingKey::FACEBOOK_PROFILE);
    }

    public function setTwitterProfile($profile): void
    {
        $this->setSetting(SettingKey::TWITTER_PROFILE, $profile);
    }

    public function getTwitterProfile(): string
    {
        return (string)$this->getSetting(SettingKey::TWITTER_PROFILE);
    }

    public function setInstagramProfile($profile): void
    {
        $this->setSetting(SettingKey::INSTAGRAM_PROFILE, $profile);
    }

    public function getInstagramProfile(): string
    {
        return (string)$this->getSetting(SettingKey::INSTAGRAM_PROFILE);
    }

    public function setLinkedInProfile($profile): void
    {
        $this->setSetting(SettingKey::LINKED_IN_PROFILE, $profile);
    }

    public function getLinkedInProfile(): string
    {
        return (string)$this->getSetting(SettingKey::LINKED_IN_PROFILE);
    }

    public function setYouTubeProfile($profile): void
    {
        $this->setSetting(SettingKey::YOU_TUBE_PROFILE, $profile);
    }

    public function getYouTubeProfile(): string
    {
        return (string)$this->getSetting(SettingKey::YOU_TUBE_PROFILE);
    }

    public function setTiktokProfile($profile): void
    {
        $this->setSetting(SettingKey::TIKTOK_PROFILE, (string)$profile);
    }

    public function getTiktokProfile(): string
    {
        return (string)$this->getSetting(SettingKey::TIKTOK_PROFILE);
    }

    public function setTelegramProfile($profile): void
    {
        $this->setSetting(SettingKey::TELEGRAM_PROFILE, (string)$profile);
    }

    public function getTelegramProfile(): string
    {
        return (string)$this->getSetting(SettingKey::TELEGRAM_PROFILE);
    }

    public function setEbayProfile($profile): void
    {
        $this->setSetting(SettingKey::EBAY_PROFILE, (string)$profile);
    }

    public function getEbayProfile(): string
    {
        return (string)$this->getSetting(SettingKey::EBAY_PROFILE);
    }
}