<?php
/*
Plugin Name: Listivo Core
Version: 2.3.71
Plugin URI: https://tangiblewp.com/listivo
Text Domain: listivo-core
Domain Path: /languages
Description: Essential Plugin required to run the Listivo WordPress Theme. It provides important functions that enable the theme's functionality.
Author: TangibleWP
Author URI: https://tangiblewp.com
*/

if (!defined('ABSPATH')) {
    exit;
}

if (PHP_VERSION_ID < 80000) {
    require_once plugin_dir_path(__FILE__) . 'inc/php-version-notice.php';
    return;
}

if (!class_exists(Elementor\Plugin::class)) {
    return;
}

const LISTIVO_CORE_VERSION = '2.3.71';

define('LISTIVO_URL', plugin_dir_url(__FILE__));
define('LISTIVO_PATH', plugin_dir_path(__FILE__));

require 'vendor/autoload.php';

require 'framework/framework.php';

require 'config/load.php';

add_action('init', static function () {
    load_plugin_textdomain('listivo-core', false, basename(__DIR__) . '/languages/');
});

add_action('plugins_loaded', static function () {
    if (!class_exists(Tangibledesign\Framework\Core\App::class)) {
        return;
    }

    Tangibledesign\Framework\Core\App::getInstance()->init();
}, 9999);

register_activation_hook(__FILE__, static function () {
    $opt = get_option(tdf_prefix() . '_importer_redirect');
    if ($opt !== '0') {
        update_option(tdf_prefix() . '_importer_redirect', 1);
    }

    update_option('elementor_onboarded', true);
});