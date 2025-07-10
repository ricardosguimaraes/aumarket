<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Models\Post\Post;
use WP_Post;

interface BasePostFactory
{
    /**
     * @param  WP_Post|int|null  $post
     * @return Post|false
     */
    public function create($post);

}