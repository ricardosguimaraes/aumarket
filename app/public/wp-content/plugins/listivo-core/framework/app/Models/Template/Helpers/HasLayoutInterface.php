<?php


namespace Tangibledesign\Framework\Models\Template\Helpers;


use Tangibledesign\Framework\Models\Template\LayoutTemplate;

/**
 * Interface HasLayoutInterface
 * @package Tangibledesign\Framework\Models\Template\Helpers
 */
interface HasLayoutInterface
{
    /**
     * @return int
     */
    public function getLayoutId(): int;

    /**
     * @return LayoutTemplate|false
     */
    public function getLayout();

}