<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetNameLength
{
    use Setting;

    /**
     * @param  int  $length
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setNameLength($length): void
    {
        $this->setSetting(SettingKey::NAME_LENGTH, (int) $length);
    }

    /**
     * @return int
     */
    public function getNameLength(): int
    {
        $length = (int) $this->getSetting(SettingKey::NAME_LENGTH);
        if (empty($length)) {
            return 70;
        }

        return $length;
    }

}