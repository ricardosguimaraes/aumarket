<?php


namespace Tangibledesign\Framework\Search;


/**
 * Interface Searchable
 * @package Tangibledesign\Framework\Search
 */
interface Searchable
{
    /**
     * @return mixed
     */
    public function getSearchField(array $config);

    /**
     * @return string
     */
    public function getKey(): string;

}