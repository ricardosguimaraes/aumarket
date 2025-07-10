<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetContactUserForm
{
    use Setting;

    /**
     * @param int $contactFormId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setContactUserForm($contactFormId): void
    {
        $this->setSetting(SettingKey::CONTACT_USER_FORM, (int)$contactFormId);
    }

    /**
     * @return int
     */
    public function getContactUserFormId(): int
    {
        return (int)$this->getSetting(SettingKey::CONTACT_USER_FORM);
    }

}