<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetListingHints
{
    use Setting;

    /**
     * @param  string  $hint
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setNameHint($hint): void
    {
        $this->setSetting(SettingKey::NAME_HINT, (string) $hint);
    }

    /**
     * @return string
     */
    public function getNameHint(): string
    {
        return (string) $this->getSetting(SettingKey::NAME_HINT);
    }

    /**
     * @param  string  $hint
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setDescriptionHint($hint): void
    {
        $this->setSetting(SettingKey::DESCRIPTION_HINT, (string) $hint);
    }

    /**
     * @return string
     */
    public function getDescriptionHint(): string
    {
        return (string) $this->getSetting(SettingKey::DESCRIPTION_HINT);
    }

}