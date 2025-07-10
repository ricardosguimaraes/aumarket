<?php

namespace Tangibledesign\Framework\Providers\LiteSpeed;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Post\PostStatus;
use WP_Post;

class LiteSpeedServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_filter('litespeed_vary_cookies', static function ($list) {
            $list[] = tdf_prefix() . '/compare';
            $list[] = tdf_prefix() . '/currency';

            return $list;
        });

        add_action('transition_post_status', static function (string $newStatus, string $oldStatus, WP_Post $post) {
            if ($newStatus !== PostStatus::PUBLISH || $post->post_type !== tdf_model_post_type()) {
                return;
            }

            do_action('litespeed_purged_all');
        }, 10, 3);
    }
}