<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetMailSettings
{
    use Setting;

    public function setSenderName($name): void
    {
        $this->setSetting(SettingKey::SENDER_NAME, $name);
    }

    public function getSenderName(): string
    {
        return (string)$this->getSetting(SettingKey::SENDER_NAME);
    }

    public function setSenderEmail($email): void
    {
        $this->setSetting(SettingKey::SENDER_EMAIL, $email);
    }

    public function getSenderEmail(): string
    {
        return (string)$this->getSetting(SettingKey::SENDER_EMAIL);
    }

    public function setMailFooter($text): void
    {
        $this->setSetting(SettingKey::MAIL_FOOTER, $text);
    }

    public function getMailFooter(): string
    {
        return (string)$this->getSetting(SettingKey::MAIL_FOOTER);
    }

}