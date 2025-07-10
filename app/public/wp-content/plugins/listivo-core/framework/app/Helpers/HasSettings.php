<?php

namespace Tangibledesign\Framework\Helpers;

trait HasSettings
{
    abstract public function getSettingKeys(): array;

    public function updateSettings(array $data, array $settingKeys = []): void
    {
        if (empty($settingKeys)) {
            $settingKeys = $this->getSettingKeys();
        }

        foreach ($settingKeys as $settingKey) {
            $value = array_key_exists($settingKey, $data) ? $data[$settingKey] : '';
            $method = $this->getSettingMethodName($settingKey);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    protected function getSettingMethodName(string $settingKey): string
    {
        return 'set' . str_replace(
                ' ',
                '',
                ucwords(str_replace('_', ' ', str_replace(tdf_prefix(), '', $settingKey)))
            );
    }

}