<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetMarketingConsents
{
    use Setting;

    public function setMarketingConsents($marketingConsents): void
    {
        $this->setSetting(SettingKey::MARKETING_CONSENTS, (int)$marketingConsents);
    }

    public function isMarketingConsentsEnabled(): bool
    {
        return (bool)$this->getSetting(SettingKey::MARKETING_CONSENTS);
    }

    public function setMarketingConsentsLabel($marketingConsentsLabel): void
    {
        $this->setSetting(SettingKey::MARKETING_CONSENTS_LABEL, $marketingConsentsLabel);
    }

    public function getMarketingConsentsLabel(): string
    {
        $label = (string)$this->getSetting(SettingKey::MARKETING_CONSENTS_LABEL);

        if (empty($label)) {
            $label = tdf_admin_string('marketing_consents_default');
        }

        return $label;
    }

    public function setMarketingConsentsRequired($marketingConsentsRequired): void
    {
        $this->setSetting(SettingKey::MARKETING_CONSENTS_REQUIRED, (int)$marketingConsentsRequired);
    }

    public function isMarketingConsentsRequired(): bool
    {
        return (bool)$this->getSetting(SettingKey::MARKETING_CONSENTS_REQUIRED);
    }

    public function setMarketingConsentsDefault($marketingConsentsDefault): void
    {
        $this->setSetting(SettingKey::MARKETING_CONSENTS_DEFAULT, (int)$marketingConsentsDefault);
    }

    public function isMarketingConsentsCheckedByDefault(): bool
    {
        return (bool)$this->getSetting(SettingKey::MARKETING_CONSENTS_DEFAULT);
    }
}