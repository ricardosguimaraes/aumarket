<?php

namespace Tangibledesign\Framework\Models\Helpers;

use WP_Post;

trait HasPost
{
    /**
     * @return WP_Post
     */
    abstract public function getPost(): WP_Post;
}