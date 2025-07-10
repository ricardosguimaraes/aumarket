<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetLegacyMode
{
    use Setting;

    /**
     * @param int $enable
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setLegacyMode($enable): void
    {
        $this->setSetting(SettingKey::LEGACY_MODE, (int)$enable);
    }

    /**
     * @return bool
     */
    public function isLegacyModeEnabled(): bool
    {
        $legacyMode = (string)$this->getSetting(SettingKey::LEGACY_MODE);
        if ($legacyMode === '') {
            return true;
        }

        return !empty((int)$legacyMode);
    }

}