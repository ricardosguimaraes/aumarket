<?php

namespace Tangibledesign\Framework\Queries;

/**
 * Class QueryAttachments
 * @package Tangibledesign\Framework\Queries
 */
class QueryAttachments extends QueryPosts
{
    /** @var string */
    protected string $postType = 'attachment';

    protected function parseArgs(): array
    {
        return [
                'post_status' => 'inherit',
            ] + parent::parseArgs();
    }
}