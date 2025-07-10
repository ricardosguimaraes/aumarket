<?php


namespace Tangibledesign\Framework\Models\Field\Helpers;


use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Helpers\HasMeta;

/**
 * Trait HasInputPlaceholder
 * @package Tangibledesign\Framework\Models\Field\Helpers
 */
trait HasInputPlaceholder
{
    use HasMeta;

    /**
     * @param string $placeholder
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setInputPlaceholder($placeholder): void
    {
        $this->setMeta(Field::INPUT_PLACEHOLDER, $placeholder);
    }

    /**
     * @return string
     */
    public function getInputPlaceholder(): string
    {
        return (string)$this->getMeta(Field::INPUT_PLACEHOLDER);
    }

    /**
     * @return bool
     */
    public function hasInputPlaceholder(): bool
    {
        return !empty($this->getInputPlaceholder());
    }

}