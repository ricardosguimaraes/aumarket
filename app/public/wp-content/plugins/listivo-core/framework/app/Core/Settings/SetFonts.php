<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetFonts
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetFonts
{
    use Setting;

    /**
     * @param string $font
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setHeadingFont($font): void
    {
        $this->setSetting(SettingKey::HEADING_FONT, $font);
    }

    /**
     * @return string
     */
    public function getHeadingFont(): string
    {
        $font = (string)$this->getSetting(SettingKey::HEADING_FONT);
        if (empty($font)) {
            return 'Comfortaa';
        }

        return $font;
    }

    /**
     * @param string $font
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setTextFont($font): void
    {
        $this->setSetting(SettingKey::TEXT_FONT, $font);
    }

    /**
     * @return string
     */
    public function getTextFont(): string
    {
        $font = (string)$this->getSetting(SettingKey::TEXT_FONT);
        if (empty($font)) {
            return 'Inter';
        }

        return $font;
    }

}