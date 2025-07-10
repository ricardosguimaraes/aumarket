<?php

namespace Tangibledesign\Framework\Models\Helpers;

use Tangibledesign\Framework\Models\Model;

trait HasFavoriteCounter
{
    use HasMeta;

    /**
     * @return int
     */
    public function getFavoriteCount(): int
    {
        return (int)$this->getMeta(Model::FAVORITE_COUNT);
    }

    public function setFavoriteCount($count): void
    {
        $this->setMeta(Model::FAVORITE_COUNT, $count);
    }
}