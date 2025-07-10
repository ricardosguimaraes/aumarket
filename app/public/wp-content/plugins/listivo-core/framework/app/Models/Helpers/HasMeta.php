<?php


namespace Tangibledesign\Framework\Models\Helpers;


/**
 * Trait HasMeta
 * @package Tangibledesign\Framework\Models\Helpers
 */
trait HasMeta
{
    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    abstract public function setMeta(string $key, $value): bool;

    /**
     * @param string $key
     * @return mixed
     */
    abstract public function getMeta(string $key);

}