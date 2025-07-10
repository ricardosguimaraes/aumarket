<?php

namespace Tangibledesign\Framework\Core\Settings;

use Tangibledesign\Framework\Widgets\General\PanelWidget;

trait SetPanelRedirects
{
    use Setting;

    public function setLoginRedirect($redirect): void
    {
        $this->setSetting(SettingKey::LOGIN_REDIRECT, $redirect);
    }

    public function getLoginRedirect(): string
    {
        $redirect = $this->getSetting(SettingKey::LOGIN_REDIRECT);
        if (empty($redirect)) {
            return PanelWidget::ACTION_LIST;
        }

        return $redirect;
    }

    public function setRegisterRedirect($redirect): void
    {
        $this->setSetting(SettingKey::REGISTER_REDIRECT, $redirect);
    }

    public function getRegisterRedirect(): string
    {
        $redirect = $this->getSetting(SettingKey::REGISTER_REDIRECT);
        if (empty($redirect)) {
            return PanelWidget::ACTION_LIST;
        }

        return $redirect;
    }

    public function setSocialLoginRedirect($redirect): void
    {
        $this->setSetting(SettingKey::SOCIAL_LOGIN_REDIRECT, $redirect);
    }

    public function getSocialLoginRedirect(): string
    {
        $redirect = $this->getSetting(SettingKey::SOCIAL_LOGIN_REDIRECT);
        if (empty($redirect)) {
            return PanelWidget::ACTION_LIST;
        }

        return $redirect;
    }

    public function setSocialRegisterRedirect($redirect): void
    {
        $this->setSetting(SettingKey::SOCIAL_REGISTER_REDIRECT, $redirect);
    }

    public function getSocialRegisterRedirect(): string
    {
        $redirect = $this->getSetting(SettingKey::SOCIAL_REGISTER_REDIRECT);
        if (empty($redirect)) {
            return PanelWidget::ACTION_LIST;
        }

        return $redirect;
    }

}