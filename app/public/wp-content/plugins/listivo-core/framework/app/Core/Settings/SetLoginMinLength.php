<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetLoginMinLength
{
    use Setting;

    /**
     * @param int $length
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setLoginMinLength($length): void
    {
        $this->setSetting(SettingKey::LOGIN_MIN_LENGTH, (int)$length);
    }

    /**
     * @return int
     */
    public function getLoginMinLength(): int
    {
        $length = (int)$this->getSetting(SettingKey::LOGIN_MIN_LENGTH);
        if (empty($length)) {
            return 1;
        }

        return $length;
    }

}