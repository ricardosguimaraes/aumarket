<?php


namespace Tangibledesign\Framework\Search;


use Tangibledesign\Framework\Search\QueryModifier\QueryModifier;

/**
 * Interface HasQueryModifier
 * @package Tangibledesign\Framework\Search
 */
interface HasQueryModifier
{
    /**
     * @return QueryModifier
     */
    public function getQueryModifier(): QueryModifier;

}