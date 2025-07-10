<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetUserRegistration
{
    use Setting;

    /**
     * @param int $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setUserRegistration($enable): void
    {
        $this->setSetting(SettingKey::USER_REGISTRATION, (int)$enable);
    }

    public function userRegistrationOpen(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::USER_REGISTRATION));
    }

    /**
     * @param int $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setUserEmailConfirmation($enable): void
    {
        $this->setSetting(SettingKey::USER_EMAIL_CONFIRMATION, (int)$enable);
    }

    public function isUserEmailConfirmationEnabled(): bool
    {
        return !empty($this->getSetting(SettingKey::USER_EMAIL_CONFIRMATION));
    }
}