<?php

namespace Tangibledesign\Framework\Models\Field\Helpers;

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Helpers\HasMeta;

trait HasDisplayValueWithFieldName
{
    use HasMeta;

    /**
     * @param int $display
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setDisplayValueWithFieldName($display): void
    {
        $this->setMeta(Field::DISPLAY_VALUE_WITH_FIELD_NAME, empty($display) ? 0 : 1);
    }

    /**
     * @return bool
     */
    public function displayValueWithFieldName(): bool
    {
        return $this->getMeta(Field::DISPLAY_VALUE_WITH_FIELD_NAME) !== '0';
    }

}