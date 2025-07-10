<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetDisableDemoImporter
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetDisableDemoImporter
{
    use Setting;

    /**
     * @param int $disable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setDisableDemoImporter($disable): void
    {
        $this->setSetting(SettingKey::DISABLE_DEMO_IMPORTER, (int)$disable);
    }

    /**
     * @return bool
     */
    public function showDemoImporter(): bool
    {
        return empty((int)$this->getSetting(SettingKey::DISABLE_DEMO_IMPORTER));
    }

}