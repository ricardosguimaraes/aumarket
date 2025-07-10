<?php

namespace Tangibledesign\Listivo\Widgets\General\Search;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\SearchField;

interface HasSidebarFields
{
    /**
     * @return Collection|SearchField[]
     */
    public function getSidebarFields(): Collection;
}