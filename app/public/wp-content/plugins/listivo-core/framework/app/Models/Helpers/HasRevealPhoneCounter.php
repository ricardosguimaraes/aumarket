<?php

namespace Tangibledesign\Framework\Models\Helpers;

use Tangibledesign\Framework\Models\Model;

trait HasRevealPhoneCounter
{
    use HasMeta;

    public function getRevealPhoneCounter(): int
    {
        return (int)$this->getMeta(Model::PHONE_REVEALS);
    }

    public function setRevealPhoneCounter($count): void
    {
        $this->setMeta(Model::PHONE_REVEALS, $count);
    }
}