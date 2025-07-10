<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetCacheSettingsTrait
{
    use Setting;

    public function setEnableCache($enabled): void
    {
        $this->setSetting(SettingKey::ENABLE_CACHE, (int)$enabled);
    }

    public function isCacheEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_CACHE));
    }

    public function setCacheDuration($duration): void
    {
        $this->setSetting(SettingKey::CACHE_DURATION, (int)$duration);
    }

    public function getCacheDuration(): int
    {
        $duration = (int)$this->getSetting(SettingKey::CACHE_DURATION);
        if ($duration <= 0 || empty($duration)) {
            return MINUTE_IN_SECONDS * 15;
        }

        return $duration;
    }
}