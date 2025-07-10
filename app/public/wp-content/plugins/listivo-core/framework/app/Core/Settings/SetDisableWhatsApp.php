<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetDisableWhatsApp
{
    use Setting;

    /**
     * @param int $disable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setDisableWhatsApp($disable): void
    {
        $this->setSetting(SettingKey::DISABLE_WHATS_APP, (int)$disable);
    }

    /**
     * @return bool
     */
    public function disableWhatsApp(): bool
    {
        return !empty($this->getSetting(SettingKey::DISABLE_WHATS_APP));
    }
}