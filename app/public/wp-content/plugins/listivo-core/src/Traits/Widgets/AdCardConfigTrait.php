<?php

namespace Tangibledesign\Listivo\Traits\Widgets;

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\Helpers\Presentation\AdCard;

trait AdCardConfigTrait
{
    public function getCardConfig(Model $model): AdCard
    {
        return new AdCard($model);
    }
}