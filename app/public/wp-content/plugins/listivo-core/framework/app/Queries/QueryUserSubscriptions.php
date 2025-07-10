<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;

class QueryUserSubscriptions extends QueryPosts
{
    protected string $postType = 'user_subs';

    protected bool $prefixPostType = true;

    public function getFactory(): BasePostFactory
    {
        return tdf_user_subscription_factory();
    }

    public function expired(): QueryUserSubscriptions
    {
        $this->metaQuery[] = [
            'key' => 'current_period_end',
            'value' => time(),
            'compare' => '<',
            'type' => 'NUMERIC',
        ];

        return $this;
    }
}