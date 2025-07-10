<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;

/**
 * Class QueryImages
 * @package Tangibledesign\Framework\Queries
 */
class QueryImages extends QueryPosts
{
    /** @var string */
    protected string $postType = 'attachment';

    protected function parseArgs(): array
    {
        return [
                'post_status' => 'inherit',
                'post_mime_type' => 'image/jpeg,image/gif,image/jpg,image/png,image/webp'
            ] + parent::parseArgs();
    }

    protected function getFactory(): BasePostFactory
    {
        return tdf_image_factory();
    }

}