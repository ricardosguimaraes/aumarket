<?php


namespace Tangibledesign\Framework\Widgets\Helpers;


use Tangibledesign\Framework\Models\Page;
use WP_Post;

/**
 * Trait HasPage
 * @package Tangibledesign\Framework\Widgets\Helpers
 */
trait HasPage
{
    /**
     * @return false|Page
     */
    public function getPage()
    {
        global $post;

        if (!$post instanceof WP_Post || $post->post_type !== 'page') {
            return false;
        }

        return new Page($post);
    }

}