<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetNameRequired
{
    use Setting;

    /**
     * @param  int  $isRequired
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setNameRequired($isRequired): void
    {
        $this->setSetting(SettingKey::NAME_REQUIRED, (int) $isRequired);
    }

    /**
     * @return bool
     */
    public function nameRequired(): bool
    {
        $isRequired = $this->getSetting(SettingKey::NAME_REQUIRED);
        if ($isRequired === null) {
            return true;
        }

        return !empty((int) $this->getSetting(SettingKey::NAME_REQUIRED));
    }

}