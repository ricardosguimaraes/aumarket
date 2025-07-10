<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetAccountType
{
    use Setting;

    /**
     * @param  int  $enabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAccountType($enabled): void
    {
        $this->setSetting(SettingKey::ACCOUNT_TYPE, (int) $enabled);
    }

    /**
     * @return bool
     */
    public function isAccountTypeEnabled(): bool
    {
        return !empty((int) $this->getSetting(SettingKey::ACCOUNT_TYPE));
    }

    /**
     * @param  int  $enabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setCanUserChangeAccountType($enabled): void
    {
        $this->setSetting(SettingKey::CAN_USER_CHANGE_ACCOUNT_TYPE, (int) $enabled);
    }

    /**
     * @return bool
     */
    public function canUserChangeAccountType(): bool
    {
        return !empty((int) $this->getSetting(SettingKey::CAN_USER_CHANGE_ACCOUNT_TYPE));
    }

}