<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetChatAppsActivationTrait
{
    use Setting;

    public function setActivateChatAppsOnRegistration($enable): void
    {
        $this->setSetting(SettingKey::ACTIVATE_CHAT_APPS_ON_REGISTRATION, (int)$enable);
    }

    public function isChatAppsOnRegistrationActivated(): bool
    {
        return !empty($this->getSetting(SettingKey::ACTIVATE_CHAT_APPS_ON_REGISTRATION));
    }
}