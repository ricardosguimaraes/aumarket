<?php

namespace Tangibledesign\Listivo\Widgets\PrintModel;

use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Framework\Widgets\Helpers\PrintModelWidget;
use Tangibledesign\Framework\Widgets\Widget;

abstract class BasePrintModelWidget extends Widget implements PrintModelWidget
{
    use HasModel;

    /**
     * @return string
     */
    protected function getTemplateDirectory(): string
    {
        return 'printModel/';
    }

}