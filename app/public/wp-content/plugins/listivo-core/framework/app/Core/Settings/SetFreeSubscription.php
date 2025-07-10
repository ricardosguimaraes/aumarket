<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetFreeSubscription
{
    use Setting;

    public function setEnableFreeSubscription($enabled): void
    {
        $this->setSetting(SettingKey::ENABLE_FREE_SUBSCRIPTION, (int)$enabled);
    }

    public function isFreeSubscriptionEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_FREE_SUBSCRIPTION));
    }

    public function setFreeSubscriptionName($name): void
    {
        $this->setSetting(SettingKey::FREE_SUBSCRIPTION_NAME, (string)$name);
    }

    public function getFreeSubscriptionName(): string
    {
        return (string)$this->getSetting(SettingKey::FREE_SUBSCRIPTION_NAME);
    }

    public function setFreeSubscriptionLabel($label): void
    {
        $this->setSetting(SettingKey::FREE_SUBSCRIPTION_LABEL, (string)$label);
    }

    public function getFreeSubscriptionLabel(): string
    {
        return (string)$this->getSetting(SettingKey::FREE_SUBSCRIPTION_LABEL);
    }

    public function setFreeSubscriptionText($text): void
    {
        $this->setSetting(SettingKey::FREE_SUBSCRIPTION_TEXT, (string)$text);
    }

    public function getFreeSubscriptionText(): string
    {
        return (string)$this->getSetting(SettingKey::FREE_SUBSCRIPTION_TEXT);
    }

    public function setFreeSubscriptionNumber($number): void
    {
        $this->setSetting(SettingKey::FREE_SUBSCRIPTION_NUMBER, (int)$number);
    }

    public function getFreeSubscriptionNumber(): int
    {
        return (int)$this->getSetting(SettingKey::FREE_SUBSCRIPTION_NUMBER);
    }

    public function setFreeSubscriptionExpire($expire): void
    {
        $this->setSetting(SettingKey::FREE_SUBSCRIPTION_EXPIRE, (int)$expire);
    }

    public function getFreeSubscriptionExpire(): int
    {
        return (int)$this->getSetting(SettingKey::FREE_SUBSCRIPTION_EXPIRE);
    }

    public function setFreeSubscriptionFeaturedExpire($featuredExpire): void
    {
        $this->setSetting(SettingKey::FREE_SUBSCRIPTION_FEATURED_EXPIRE, (int)$featuredExpire);
    }

    public function getFreeSubscriptionFeaturedExpire(): int
    {
        return (int)$this->getSetting(SettingKey::FREE_SUBSCRIPTION_FEATURED_EXPIRE);
    }

    public function setFreeSubscriptionBumpsNumber($number): void
    {
        $this->setSetting(SettingKey::FREE_SUBSCRIPTION_BUMPS_NUMBER, (int)$number);
    }

    public function getFreeSubscriptionBumpsNumber(): int
    {
        return (int)$this->getSetting(SettingKey::FREE_SUBSCRIPTION_BUMPS_NUMBER);
    }

    public function setFreeSubscriptionBumpsInterval($days): void
    {
        $this->setSetting(SettingKey::FREE_SUBSCRIPTION_BUMPS_INTERVAL, (int)$days);
    }

    public function getFreeSubscriptionBumpsInterval(): int
    {
        return (int)$this->getSetting(SettingKey::FREE_SUBSCRIPTION_BUMPS_INTERVAL);
    }
}