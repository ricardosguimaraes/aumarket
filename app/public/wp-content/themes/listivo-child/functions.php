<?php


add_action('wp_enqueue_scripts', static function () {
    $deps = [];

    if (class_exists(\Elementor\Plugin::class)) {
        $deps[] = 'elementor-frontend';
    }

    if (is_rtl()) {
        wp_enqueue_style('listivo-rtl', get_template_directory_uri().'/style-rtl.css', $deps, LISTIVO_VERSION);
        wp_enqueue_style('listivo-child', get_stylesheet_directory_uri().'/style.css',
            ['listivo-rtl'], LISTIVO_VERSION);
    } else {
        wp_enqueue_style('listivo', get_template_directory_uri().'/style.css', $deps, LISTIVO_VERSION);
        wp_enqueue_style('listivo-child', get_stylesheet_directory_uri().'/style.css',
            ['listivo'], LISTIVO_VERSION);
    }
});

add_action('after_setup_theme', static function () {
    load_child_theme_textdomain('listivo', get_stylesheet_directory().'/languages');
});

add_action('wp_enqueue_scripts', function() {
    if (is_user_logged_in() && isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/panel/settings') !== false) {
        wp_enqueue_script('viewshop-btn', get_stylesheet_directory_uri() . '/viewshop-btn.js', [], null, true);
        $current_user = wp_get_current_user();
        wp_localize_script('viewshop-btn', 'aumarketUser', [
            'username' => $current_user->user_login
        ]);
    }
});
