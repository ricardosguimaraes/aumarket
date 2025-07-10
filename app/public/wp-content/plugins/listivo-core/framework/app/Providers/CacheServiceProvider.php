<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class CacheServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_tdf/cache/clear', [$this, 'clearCache']);
    }

    public function clearCache(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die('Access Denied');
        }

        global $wpdb;
        $query = "DELETE FROM $wpdb->options WHERE option_name LIKE '%" . tdf_prefix() . "cache%'";
        $wpdb->query($query);

        $redirectUrl = apply_filters('tdf/cache/cleared/redirect', admin_url('admin.php?page=' . tdf_prefix() . '_basic_setup&tab=search'));

        wp_redirect($redirectUrl);
        exit;
    }
}