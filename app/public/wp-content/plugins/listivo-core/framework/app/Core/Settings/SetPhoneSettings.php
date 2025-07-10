<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetPhoneSettings
{
    use Setting;

    public function setPhoneLogic($phoneLogic): void
    {
        $this->setSetting(SettingKey::PHONE_LOGIC, $phoneLogic);
    }

    public function getPhoneLogic(): string
    {
        $logic = (string)$this->getSetting(SettingKey::PHONE_LOGIC);

        if (empty($logic)) {
            return 'optional_show';
        }

        return $logic;
    }

    public function isPhoneLogic(string $phoneLogic): bool
    {
        return $this->getPhoneLogic() === $phoneLogic;
    }

    public function showPhoneOnRegister(): bool
    {
        $logic = $this->getPhoneLogic();

        return $logic === 'optional_show' || $logic === 'required';
    }

    public function isPhoneRequired(): bool
    {
        return $this->getPhoneLogic() === 'required';
    }

    public function showPhoneInSettings(): bool
    {
        $logic = $this->getPhoneLogic();

        return $logic === 'optional_show' || $logic === 'required' || $logic === 'optional_hide';
    }

    public function setPhoneCountryCodeSelect($enabled): void
    {
        $this->setSetting(SettingKey::PHONE_COUNTRY_CODE_SELECT, (int)$enabled);
    }

    public function isPhoneCountryCodeSelectEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::PHONE_COUNTRY_CODE_SELECT));
    }

    public function setPhoneDefaultCountryCode($countryCode): void
    {
        $this->setSetting(SettingKey::PHONE_DEFAULT_COUNTRY_CODE, $countryCode);
    }

    public function getPhoneDefaultCountryCode(): string
    {
        return (string)$this->getSetting(SettingKey::PHONE_DEFAULT_COUNTRY_CODE);
    }

    public function setUserPhoneUnique($enabled): void
    {
        $this->setSetting(SettingKey::USER_PHONE_UNIQUE, (int)$enabled);
    }

    public function isUserPhoneUnique(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::USER_PHONE_UNIQUE));
    }
}