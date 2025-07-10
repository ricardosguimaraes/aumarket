<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetFooterSettings
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetFooterSettings
{
    use Setting;

    /**
     * @param string $copyrightsText
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setCopyrightsText($copyrightsText): void
    {
        $this->setSetting(SettingKey::COPYRIGHTS_TEXT, $copyrightsText);
    }

    /**
     * @return string
     */
    public function getCopyrightsText(): string
    {
        return (string)$this->getSetting(SettingKey::COPYRIGHTS_TEXT);
    }

}