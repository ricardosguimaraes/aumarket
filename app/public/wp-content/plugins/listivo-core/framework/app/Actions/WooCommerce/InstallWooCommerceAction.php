<?php

namespace Tangibledesign\Framework\Actions\WooCommerce;

use Plugin_Upgrader;
use WP_Ajax_Upgrader_Skin;

class InstallWooCommerceAction
{

    public static function install(): void
    {
        require_once(ABSPATH . 'wp-admin/includes/plugin-install.php');
        require_once(ABSPATH . 'wp-admin/includes/class-wp-upgrader.php');
        require_once(ABSPATH . 'wp-admin/includes/class-wp-ajax-upgrader-skin.php');
        require_once(ABSPATH . 'wp-admin/includes/class-plugin-upgrader.php');

        $api = plugins_api(
            'plugin_information',
            [
                'slug' => 'woocommerce',
                'fields' => [
                    'short_description' => false,
                    'sections' => false,
                    'requires' => false,
                    'rating' => false,
                    'ratings' => false,
                    'downloaded' => false,
                    'last_updated' => false,
                    'added' => false,
                    'tags' => false,
                    'compatibility' => false,
                    'homepage' => false,
                    'donate_link' => false,
                ],
            ]
        );

        $upgrader = new Plugin_Upgrader(new WP_Ajax_Upgrader_Skin());
        $upgrader->install($api->download_link);

        define('WP_ADMIN', TRUE);
        define('WP_NETWORK_ADMIN', TRUE);
        define('WP_USER_ADMIN', TRUE);

        /** @noinspection PhpIncludeInspection */
        require_once('../wp-load.php');
        /** @noinspection PhpIncludeInspection */
        require_once('../wp-admin/includes/admin.php');
        /** @noinspection PhpIncludeInspection */
        require_once('../wp-admin/includes/plugin.php');

        activate_plugin(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php');
    }

}