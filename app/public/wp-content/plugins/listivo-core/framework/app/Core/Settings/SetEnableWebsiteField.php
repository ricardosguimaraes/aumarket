<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetEnableWebsiteField
{
    use Setting;

    /**
     * @param int $enable
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setEnableWebsiteField($enable): void
    {
        $this->setSetting(SettingKey::ENABLE_WEBSITE_FIELD, (int)$enable);
    }

    /**
     * @return bool
     */
    public function isWebsiteFieldEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_WEBSITE_FIELD));
    }

}