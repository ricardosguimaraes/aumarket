<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetDescriptionRequired
{
    use Setting;

    /**
     * @param int $isRequired
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setDescriptionRequired($isRequired): void
    {
        $this->setSetting(SettingKey::DESCRIPTION_REQUIRED, (int)$isRequired);
    }

    /**
     * @return bool
     */
    public function descriptionRequired(): bool
    {
        return !empty($this->getSetting(SettingKey::DESCRIPTION_REQUIRED));
    }

}