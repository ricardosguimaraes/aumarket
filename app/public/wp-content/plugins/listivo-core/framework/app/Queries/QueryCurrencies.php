<?php

namespace Tangibledesign\Framework\Queries;

/**
 * Class QueryCurrencies
 * @package Tangibledesign\Framework\Queries
 */
class QueryCurrencies extends QueryTerms
{
    /** @var string */
    protected string $taxonomy = 'currency';

    /** @var bool */
    protected bool $prefixTaxonomy = true;
}