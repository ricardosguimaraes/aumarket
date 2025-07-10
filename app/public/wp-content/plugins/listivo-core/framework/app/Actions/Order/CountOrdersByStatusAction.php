<?php

namespace Tangibledesign\Framework\Actions\Order;

use Tangibledesign\Framework\Models\Post\PostStatus;
use WP_Query;

class CountOrdersByStatusAction
{

    /**
     * @param  string  $status
     * @param  array|int  $userIn
     * @return int
     */
    public function execute(string $status = 'any', $userIn = []): int
    {
        if (!is_array($userIn)) {
            $userIn = [$userIn];
        }

        $args = [
            'posts_per_page' => -1,
            'return' => 'ids',
            'post_type' => tdf_prefix().'_order',
            'post_status' => PostStatus::PUBLISH,
            'author__in' => $userIn,
        ];

        if ($status !== 'any') {
            $args['meta_query'] = [
                [
                    'key' => 'status',
                    'value' => $status,
                ],
            ];
        }

        return (new WP_Query($args))->found_posts;
    }

}