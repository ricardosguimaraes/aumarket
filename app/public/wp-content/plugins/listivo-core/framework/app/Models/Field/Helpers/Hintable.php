<?php

namespace Tangibledesign\Framework\Models\Field\Helpers;

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Helpers\HasMeta;

trait Hintable
{
    use HasMeta;

    /**
     * @param  string  $hint
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setHint($hint): void
    {
        $this->setMeta(Field::HINT, (string) $hint);
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return (string) $this->getMeta(Field::HINT);
    }

}