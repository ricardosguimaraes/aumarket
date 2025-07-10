<?php

namespace Tangibledesign\Framework\Providers;

use Elementor\Plugin;
use Tangibledesign\Framework\Core\ServiceProvider;
use WP_Query;

class WordPressServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['favicon_url'] = static function () {
            $iconId = get_option('site_icon', false);
            if (empty($iconId)) {
                return 'data:;base64,iVBORw0KGgo=';
            }

            $iconUrl = wp_get_attachment_image_url($iconId, 'full', true);
            if (empty($iconUrl)) {
                return 'data:;base64,iVBORw0KGgo=';
            }

            return $iconUrl;
        };
    }

    public function afterInitiation(): void
    {
        add_filter('query_vars', static function ($vars) {
            $vars[] = tdf_prefix() . '-custom-url';

            return $vars;
        });

        add_action('wp_head', static function () {
            ?>
            <link rel="icon" href="<?php echo esc_attr(tdf_app('favicon_url')); ?>">
            <?php
        });

        add_filter('xmlrpc_enabled', '__return_false');

        add_filter('show_admin_bar', static function () {
            if (!is_user_logged_in()) {
                return false;
            }

            return current_user_can('manage_options') && empty($_GET['print']);
        });

        add_filter('pre_get_posts', static function (WP_Query $query) {
            if ($query->is_search && !is_admin()) {
                $query->set('post_type', 'post');
            }

            if ($query->is_search && !is_admin() && (is_post_type_archive(tdf_model_post_type()) || (defined('REST_REQUEST') && REST_REQUEST))) {
                $query->set('post_type', tdf_model_post_type());
            }

            return $query;
        });

        add_filter('posts_results', static function ($posts) {
            if (empty($posts) || !is_preview() || !is_user_logged_in()) {
                return $posts;
            }

            if ((int)$posts[0]->post_author === get_current_user_id()) {
                $posts[0]->post_status = 'publish';
            }

            return $posts;
        }, 10, 2);

        add_action(tdf_prefix() . '/urls/flush', [$this, 'initFlush']);

        add_action('admin_init', [$this, 'flush']);

        add_action('widgets_init', [$this, 'registerWidgets']);

        add_filter('body_class', static function ($classes) {
            $classes[] = tdf_prefix() . '-' . tdf_app('version');

            if (is_user_logged_in()) {
                /** @noinspection NullPointerExceptionInspection */
                $classes[] = tdf_current_user()->getUserRole();
            }

            if (tdf_settings()->isLegacyModeEnabled()) {
                $classes[] = tdf_prefix() . '-legacy-mode';
            }

            return $classes;
        });

        add_filter('wp_dropdown_users_args', static function ($args) {
            $args['capability'] = [];
            return $args;
        });

        add_filter('use_block_editor_for_post_type', static function ($currentStatus, $postType) {
            if ($postType === tdf_model_post_type()) {
                return false;
            }

            return $currentStatus;
        }, 10, 2);

        add_action('updated_option', function ($name) {
            if ($name === 'WPLANG') {
                Plugin::instance()->files_manager->clear_cache();
            }
        });
    }

    public function registerWidgets(): void
    {
        foreach (apply_filters('tdf/wp/widgets', []) as $widgetClass) {
            register_widget($widgetClass);
        }
    }

    public function initFlush(): void
    {
        update_option(tdf_prefix() . '_flush_urls', 1);
    }

    public function flush(): void
    {
        if (empty(get_option(tdf_prefix() . '_flush_urls'))) {
            return;
        }

        flush_rewrite_rules();

        Plugin::instance()->files_manager->clear_cache();

        update_option(tdf_prefix() . '_flush_urls', 0);
    }
}