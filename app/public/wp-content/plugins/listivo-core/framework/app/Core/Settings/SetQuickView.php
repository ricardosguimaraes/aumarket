<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetQuickView
{
    use Setting;

    /**
     * @param int $enabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setQuickView($enabled): void
    {
        $this->setSetting(SettingKey::QUICK_VIEW, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function isQuickViewEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::QUICK_VIEW));
    }

}