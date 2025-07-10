<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetDefaultTemplates
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetDefaultTemplates
{
    use Setting;

    /**
     * @param array $values
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setDefaultTemplates($values): void
    {
        if (!is_array($values)) {
            return;
        }

        /** @noinspection AdditionOperationOnArraysInspection */
        $this->setSetting(SettingKey::DEFAULT_TEMPLATES, $values + $this->getDefaultTemplates());
    }

    /**
     * @return array
     */
    public function getDefaultTemplates(): array
    {
        $defaultTemplates = $this->getSetting(SettingKey::DEFAULT_TEMPLATES);
        if (!is_array($defaultTemplates)) {
            return [];
        }

        return $defaultTemplates;
    }

}