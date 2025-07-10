<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;

/**
 * Class QueryFields
 * @package Tangibledesign\Framework\Queries
 */
class QueryFields extends QueryPosts
{
    /** @var string */
    protected string $postType = 'field';

    /** @var bool */
    protected bool $prefixPostType = true;

    protected function getFactory(): BasePostFactory
    {
        return tdf_field_factory();
    }

}