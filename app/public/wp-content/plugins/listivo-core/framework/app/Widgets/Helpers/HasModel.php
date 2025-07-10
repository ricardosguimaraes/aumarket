<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

use Tangibledesign\Framework\Models\Model;

trait HasModel
{
    /**
     * @return Model|false
     */
    public function getModel()
    {
        global ${tdf_short_prefix() . 'Model'};

        if (!${tdf_short_prefix() . 'Model'} instanceof Model) {
            return false;
        }

        return ${tdf_short_prefix() . 'Model'};
    }
}