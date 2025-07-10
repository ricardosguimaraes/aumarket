<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

use Tangibledesign\Framework\Widgets\Widget;

abstract class BasePostArchiveWidget extends Widget implements PostArchiveWidget
{
    /**
     * @return string
     */
    protected function getTemplateDirectory(): string
    {
        return 'blog/';
    }

}