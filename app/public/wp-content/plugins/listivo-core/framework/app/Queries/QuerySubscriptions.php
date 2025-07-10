<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;

class QuerySubscriptions extends QueryPosts
{
    protected string $postType = 'subscription';

    protected bool $prefixPostType = true;

    protected function getFactory(): BasePostFactory
    {
        return tdf_subscription_factory();
    }

}