<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetSubscriptionsSettingsTrait
{
    use Setting;

    public function setSubscriptionRenewalPolicy($renewalPolicy): void
    {
        $this->setSetting(SettingKey::SUBSCRIPTION_RENEWAL_POLICY, (string)$renewalPolicy);
    }

    public function getSubscriptionRenewalPolicy(): string
    {
        $setting = (string)$this->getSetting(SettingKey::SUBSCRIPTION_RENEWAL_POLICY);
        if (empty($setting)) {
            return SettingKey::SUBSCRIPTION_RENEWAL_POLICY_ACCUMULATE;
        }

        return $setting;
    }
}