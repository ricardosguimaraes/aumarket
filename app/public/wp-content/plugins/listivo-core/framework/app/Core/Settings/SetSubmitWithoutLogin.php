<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetSubmitWithoutLogin
{
    use Setting;

    /**
     * @param string $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setSubmitWithoutLogin($enable): void
    {
        $this->setSetting(SettingKey::SUBMIT_WITHOUT_LOGIN, (int)$enable);
    }

    /**
     * @return bool
     */
    public function submitWithoutLogin(): bool
    {
        return !empty($this->getSetting(SettingKey::SUBMIT_WITHOUT_LOGIN));
    }

}