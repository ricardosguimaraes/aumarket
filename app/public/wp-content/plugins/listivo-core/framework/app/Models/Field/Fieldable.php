<?php


namespace Tangibledesign\Framework\Models\Field;


/**
 * Interface Fieldable
 * @package Tangibledesign\Framework\Models\Field
 */
interface Fieldable
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function setMeta(string $key, $value): bool;

    /**
     * @param string $key
     * @return mixed
     */
    public function getMeta(string $key);

}