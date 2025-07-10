<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetDescriptionSimpleEditor
{
    use Setting;

    /**
     * @param $enabled
     */
    public function setDescriptionSimpleEditor($enabled): void
    {
        $this->setSetting(SettingKey::DESCRIPTION_SIMPLE_EDITOR, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function isDescriptionSimpleEditorEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::DESCRIPTION_SIMPLE_EDITOR));
    }

}