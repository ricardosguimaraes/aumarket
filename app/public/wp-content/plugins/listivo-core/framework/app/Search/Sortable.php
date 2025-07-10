<?php


namespace Tangibledesign\Framework\Search;


/**
 * Interface Sortable
 * @package Tangibledesign\Framework\Search
 */
interface Sortable
{
    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getSlug(): string;

}