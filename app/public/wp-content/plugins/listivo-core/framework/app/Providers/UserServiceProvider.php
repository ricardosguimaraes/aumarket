<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use WP_User;

/**
 * Class UserServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class UserServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['current_user'] = static function () {
            if (!is_user_logged_in()) {
                return false;
            }

            $user = _wp_get_current_user();
            if (!$user instanceof WP_User) {
                return false;
            }

            return tdf_user_factory()->create($user);
        };

        $this->container['current_user_role'] = static function () {
            $user = tdf_current_user();
            if (!$user) {
                return '';
            }

            return $user->getUserRole();
        };
    }

    /**
     * @return void
     */
    public function afterInitiation(): void
    {
        add_filter('show_admin_bar', static function () {
            return current_user_can('manage_options');
        });

        add_action('init', static function () {
            global $wp_rewrite;
            $wp_rewrite->author_base = tdf_slug('user');
        });

        add_action('init', static function () {
            if (!is_user_logged_in()) {
                return;
            }

            /** @noinspection NullPointerExceptionInspection */
            tdf_current_user()->updateLastActivity();
        });
    }

}