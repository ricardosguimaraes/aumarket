<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetBreadcrumbs
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetBreadcrumbs
{
    use Setting;

    /**
     * @param array $taxonomyKeys
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setBreadcrumbs($taxonomyKeys): void
    {
        $this->setSetting(SettingKey::BREADCRUMBS, $taxonomyKeys);
    }

    /**
     * @return array
     */
    public function getBreadcrumbs(): array
    {
        $taxonomyKeys = $this->getSetting(SettingKey::BREADCRUMBS);
        if (!is_array($taxonomyKeys)) {
            return [];
        }

        return $taxonomyKeys;
    }

}