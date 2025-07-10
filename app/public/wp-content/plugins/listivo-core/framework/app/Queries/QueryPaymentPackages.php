<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;

class QueryPaymentPackages extends QueryPosts
{
    protected string $postType = 'package';

    protected bool $prefixPostType = true;

    protected function getFactory(): BasePostFactory
    {
        return tdf_payment_package_factory();
    }
}