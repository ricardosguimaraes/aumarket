<?php


namespace Tangibledesign\Framework\Models\Field\Helpers;


use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Helpers\HasMeta;

/**
 * Trait HasTextAfterValue
 * @package Tangibledesign\Framework\Models\Field\Helpers
 */
trait HasTextAfterValue
{
    use HasMeta;

    /**
     * @param string $text
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setTextBeforeValue($text): void
    {
        $this->setMeta(Field::TEXT_BEFORE_VALUE, $text);
    }

    /**
     * @return string
     */
    public function getTextBeforeValue(): string
    {
        return (string)$this->getMeta(Field::TEXT_BEFORE_VALUE);
    }

    /**
     * @param string $text
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setTextAfterValue($text): void
    {
        $this->setMeta(Field::TEXT_AFTER_VALUE, $text);
    }

    /**
     * @return string
     */
    public function getTextAfterValue(): string
    {
        return (string)$this->getMeta(Field::TEXT_AFTER_VALUE);
    }
}