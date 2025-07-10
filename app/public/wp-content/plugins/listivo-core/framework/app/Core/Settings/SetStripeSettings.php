<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetStripeSettings
{
    use Setting;

    public function setStripeEnabled($enabled): void
    {
        $this->setSetting(SettingKey::STRIPE_ENABLED, (int)$enabled);
    }

    public function isStripeEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::STRIPE_ENABLED));
    }

    public function setStripePublishableKey($publishableKey): void
    {
        $this->setSetting(SettingKey::STRIPE_PUBLISHABLE_KEY, (string)$publishableKey);
    }

    public function getStripePublishableKey(): string
    {
        return (string)$this->getSetting(SettingKey::STRIPE_PUBLISHABLE_KEY);
    }

    public function setStripeSecretKey($secretKey): void
    {
        $this->setSetting(SettingKey::STRIPE_SECRET_KEY, (string)$secretKey);
    }

    public function getStripeSecretKey(): string
    {
        return (string)$this->getSetting(SettingKey::STRIPE_SECRET_KEY);
    }

    public function setStripeWebhookSecret($webhookSecret): void
    {
        $this->setSetting(SettingKey::STRIPE_WEBHOOK_SECRET, (string)$webhookSecret);
    }

    public function getStripeWebhookSecret(): string
    {
        return (string)$this->getSetting(SettingKey::STRIPE_WEBHOOK_SECRET);
    }

    public function setStripeCurrency($currency): void
    {
        $this->setSetting(SettingKey::STRIPE_CURRENCY, (string)$currency);
    }

    public function getStripeCurrency(): string
    {
        $currency = (string)$this->getSetting(SettingKey::STRIPE_CURRENCY);
        if (empty($currency)) {
            $currency = 'usd';
        }

        return $currency;
    }

    public function setStripeRequireBillingAddressCollection($requireBillingAddressCollection): void
    {
        $this->setSetting(SettingKey::STRIPE_REQUIRE_BILLING_ADDRESS_COLLECTION, (int)$requireBillingAddressCollection);
    }

    public function requireBillingAddressCollection(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::STRIPE_REQUIRE_BILLING_ADDRESS_COLLECTION));
    }

    public function setStripeAllowPromotionCodes($enabled): void
    {
        $this->setSetting(SettingKey::STRIPE_ALLOW_PROMOTION_CODES, (int)$enabled);
    }

    public function allowPromotionCodes(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::STRIPE_ALLOW_PROMOTION_CODES));
    }
}