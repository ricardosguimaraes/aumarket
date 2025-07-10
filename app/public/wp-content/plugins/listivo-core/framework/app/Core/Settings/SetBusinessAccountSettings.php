<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetBusinessAccountSettings
{
    use Setting;

    /**
     * @param  int  $isEnabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setEnableCompanyInformation($isEnabled): void
    {
        $this->setSetting(SettingKey::ENABLE_COMPANY_INFORMATION, (int)$isEnabled);
    }

    public function isCompanyInformationEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_COMPANY_INFORMATION));
    }

    /**
     * @param  int  $isEnabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setRequireCompanyInformation($isEnabled): void
    {
        $this->setSetting(SettingKey::REQUIRE_COMPANY_INFORMATION, (int)$isEnabled);
    }

    public function requireCompanyInformation(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::REQUIRE_COMPANY_INFORMATION));
    }

    /**
     * @param  int  $show
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setShowRegisterFormCompanyInformation($show): void
    {
        $this->setSetting(SettingKey::SHOW_REGISTER_FORM_COMPANY_INFORMATION, (int)$show);
    }

    public function showCompanyInformationFieldOnRegisterForm(): bool
    {
        if ($this->requireCompanyInformation()) {
            return true;
        }

        return !empty((int)$this->getSetting(SettingKey::SHOW_REGISTER_FORM_COMPANY_INFORMATION));
    }

    /**
     * @param  int  $isEnabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setEnableBusinessAccountFullName($isEnabled): void
    {
        $this->setSetting(SettingKey::ENABLE_BUSINESS_ACCOUNT_FULL_NAME, (int)$isEnabled);
    }

    public function isFullNameEnabledForBusinessAccount(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_BUSINESS_ACCOUNT_FULL_NAME));
    }

    /**
     * @param  int  $isEnabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setRequireBusinessAccountFullName($isEnabled): void
    {
        $this->setSetting(SettingKey::REQUIRE_BUSINESS_ACCOUNT_FULL_NAME, (int)$isEnabled);
    }

    public function isFullNameRequiredForBusinessAccount(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::REQUIRE_BUSINESS_ACCOUNT_FULL_NAME));
    }

    /**
     * @param  int  $show
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setShowRegisterFormBusinessAccountFullName($show): void
    {
        $this->setSetting(SettingKey::SHOW_REGISTER_FORM_BUSINESS_ACCOUNT_FULL_NAME, (int)$show);
    }

    public function showFullNameFieldOnRegisterFormForBusinessAccount(): bool
    {
        if ($this->isFullNameRequiredForBusinessAccount()) {
            return true;
        }

        return !empty((int)$this->getSetting(SettingKey::SHOW_REGISTER_FORM_BUSINESS_ACCOUNT_FULL_NAME));
    }

    public function setDisableBusinessRoleModels($disable): void
    {
        $this->setSetting(SettingKey::DISABLE_BUSINESS_ROLE_MODELS, (int)$disable);
    }

    public function isBusinessRoleModelsDisabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::DISABLE_BUSINESS_ROLE_MODELS));
    }

}