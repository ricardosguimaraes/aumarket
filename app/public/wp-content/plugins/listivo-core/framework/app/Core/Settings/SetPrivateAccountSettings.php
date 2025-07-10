<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetPrivateAccountSettings
{
    use Setting;

    /**
     * @param  int  $isEnabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setEnablePrivateAccountFullName($isEnabled): void
    {
        $this->setSetting(SettingKey::ENABLE_PRIVATE_ACCOUNT_FULL_NAME, (int)$isEnabled);
    }

    public function isFullNameEnabledForPrivateAccount(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_PRIVATE_ACCOUNT_FULL_NAME));
    }

    /**
     * @param  int  $isEnabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setRequirePrivateAccountFullName($isEnabled): void
    {
        $this->setSetting(SettingKey::REQUIRE_PRIVATE_ACCOUNT_FULL_NAME, (int)$isEnabled);
    }

    public function isFullNameRequiredForPrivateAccount(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::REQUIRE_PRIVATE_ACCOUNT_FULL_NAME));
    }

    /**
     * @param  int  $show
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setShowRegisterFormPrivateAccountFullName($show): void
    {
        $this->setSetting(SettingKey::SHOW_REGISTER_FORM_PRIVATE_ACCOUNT_FULL_NAME, (int)$show);
    }

    public function showFullNameFieldOnRegisterFormForPrivateAccount(): bool
    {
        if ($this->isFullNameRequiredForPrivateAccount()) {
            return true;
        }

        return !empty((int)$this->getSetting(SettingKey::SHOW_REGISTER_FORM_PRIVATE_ACCOUNT_FULL_NAME));
    }

    public function setDisablePrivateRoleModels($disable): void
    {
        $this->setSetting(SettingKey::DISABLE_PRIVATE_ROLE_MODELS, (int)$disable);
    }

    public function isPrivateRoleModelsDisabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::DISABLE_PRIVATE_ROLE_MODELS));
    }

}