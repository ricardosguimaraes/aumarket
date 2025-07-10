<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetCompareModels
{
    use Setting;

    /**
     * @param int $enabled
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setCompareModels($enabled): void
    {
        $this->setSetting(SettingKey::COMPARE_MODELS, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function isCompareModelsEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::COMPARE_MODELS));
    }

}