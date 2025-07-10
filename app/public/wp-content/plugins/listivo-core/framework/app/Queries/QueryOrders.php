<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;

class QueryOrders extends QueryPosts
{
    protected string $postType = 'order';

    protected bool $prefixPostType = true;

    public function getFactory(): BasePostFactory
    {
        return tdf_order_factory();
    }

}