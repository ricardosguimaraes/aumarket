<?php

namespace Tangibledesign\Listivo\Widgets\General\Search;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\SearchField;

interface HasPrimaryFields
{
    /**
     * @return Collection|SearchField[]
     */
    public function getPrimaryFields(): Collection;

}