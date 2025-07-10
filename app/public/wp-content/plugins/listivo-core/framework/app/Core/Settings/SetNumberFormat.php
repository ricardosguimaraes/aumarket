<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetNumberFormat
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetNumberFormat
{
    use Setting;

    /**
     * @param string $decimalSeparator
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setDecimalSeparator($decimalSeparator): void
    {
        $this->setSetting(SettingKey::DECIMAL_SEPARATOR, $decimalSeparator);
    }

    /**
     * @return string
     */
    public function getDecimalSeparator(): string
    {
        $decimalSeparator = (string)$this->getSetting(SettingKey::DECIMAL_SEPARATOR);

        if (empty($decimalSeparator)) {
            return '.';
        }

        return $decimalSeparator;
    }

    /**
     * @param string $thousandsSeparator
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setThousandsSeparator($thousandsSeparator): void
    {
        $this->setSetting(SettingKey::THOUSANDS_SEPARATOR, $thousandsSeparator);
    }

    /**
     * @return string
     */
    public function getThousandsSeparator(): string
    {
        return (string)$this->getSetting(SettingKey::THOUSANDS_SEPARATOR);
    }

}