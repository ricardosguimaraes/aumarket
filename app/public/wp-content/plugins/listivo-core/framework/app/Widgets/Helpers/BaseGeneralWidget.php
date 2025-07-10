<?php


namespace Tangibledesign\Framework\Widgets\Helpers;


use Tangibledesign\Framework\Widgets\Widget;

/**
 * Class BaseGeneralWidget
 * @package Tangibledesign\Framework\Widgets\Helpers
 */
abstract class BaseGeneralWidget extends Widget implements GeneralWidget
{
    /**
     * @return string
     */
    protected function getTemplateDirectory(): string
    {
        return 'general/';
    }

}