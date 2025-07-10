<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait Setting
 * @package Tangibledesign\Framework\Core\Settings
 */
trait Setting
{
    /**
     * @param string $key
     * @param mixed $value
     */
    abstract protected function setSetting(string $key, $value): void;

    /**
     * @param string $key
     * @return mixed
     */
    abstract protected function getSetting(string $key);

}