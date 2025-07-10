<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetDisableViber
{
    use Setting;

    /**
     * @param int $disable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setDisableViber($disable): void
    {
        $this->setSetting(SettingKey::DISABLE_VIBER, (int)$disable);
    }

    /**
     * @return bool
     */
    public function disableViber(): bool
    {
        return !empty($this->getSetting(SettingKey::DISABLE_VIBER));
    }

}