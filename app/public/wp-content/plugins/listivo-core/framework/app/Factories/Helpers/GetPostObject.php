<?php

namespace Tangibledesign\Framework\Factories\Helpers;

use WP_Post;

trait GetPostObject
{
    /**
     * @param WP_Post|int|null $post
     * @return WP_Post|false
     */
    protected function getPostObject($post)
    {
        if ($post instanceof WP_Post) {
            return $post;
        }

        if (!is_int($post)) {
            return false;
        }

        $postObject = get_post($post);
        return $postObject instanceof WP_Post ? $postObject : false;
    }

}