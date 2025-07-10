<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetUserPhoneVerification
{
    use Setting;

    /**
     * @param  int  $enabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setUserPhoneVerification($enabled): void
    {
        $this->setSetting(SettingKey::USER_PHONE_VERIFICATION, (int)$enabled);
    }

    public function isUserPhoneVerificationEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::USER_PHONE_VERIFICATION));
    }
}