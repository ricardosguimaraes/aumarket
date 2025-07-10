<?php

const LISTIVO_VERSION = '2.3.71';

require get_template_directory() . '/basic.php';
require get_template_directory() . '/src/tgm/class-tgm-plugin-activation.php';

add_action('after_setup_theme', static function () {
    add_theme_support('post-thumbnails');
    add_theme_support('nav-menus');
    add_theme_support('title-tag');
    add_theme_support('woocommerce');
    add_theme_support('custom-logo', [
        'width' => 160,
        'height' => 36,
    ]);
    add_theme_support(
        'html5', [
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ]
    );

    load_theme_textdomain('listivo', get_template_directory() . '/languages');

    register_nav_menus(['listivo-primary' => esc_html__('Listivo Theme Default Menu', 'listivo')]);
});

add_action('widgets_init', static function () {
    register_sidebar(
        [
            'name' => esc_html__('Listivo Sidebar', 'listivo'),
            'id' => 'listivo-sidebar',
            'description' => esc_html__('Add widgets here.', 'listivo'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="listivo-widget-title">',
            'after_title' => '</h3>',
        ]
    );
});

add_action('tgmpa_register', static function () {
    tgmpa(
        apply_filters('listivo/plugins', [
            [
                'name' => esc_html__('Contact Form 7', 'listivo'),
                'slug' => 'contact-form-7',
                'required' => true,
            ],
            [
                'name' => esc_html__('Elementor', 'listivo'),
                'slug' => 'elementor',
                'required' => true,
                'version' => '3.1.4',
                'force_activation' => false,
                'force_deactivation' => false,
            ],
            [
                'name' => esc_html__('Listivo Core', 'listivo'),
                'slug' => 'listivo-core',
                'source' => get_template_directory() . '/src/tgm/plugins/listivo-core.zip',
                'required' => true,
                'version' => '2.3.71',
                'force_activation' => false,
                'force_deactivation' => false,
            ],
            [
                'name' => esc_html__('Listivo Updater', 'listivo'),
                'slug' => 'listivo-updater',
                'source' => get_template_directory() . '/src/tgm/plugins/listivo-updater.zip',
                'required' => false,
                'version' => '1.0.2',
                'force_activation' => false,
                'force_deactivation' => false,
            ],
            [
                'name' => esc_html__('MC4WP', 'listivo'),
                'slug' => 'mailchimp-for-wp',
                'required' => false,
                'version' => '4.8.1',
                'force_activation' => false,
                'force_deactivation' => false,
            ],
        ])
    );
});

add_action('wp_enqueue_scripts', static function () {
    $deps = [];

    if (class_exists(\Elementor\Plugin::class)) {
        $deps[] = 'elementor-frontend';
    }

    if (is_rtl()) {
        wp_enqueue_style('listivo-rtl', get_template_directory_uri() . '/style-rtl.css', $deps, LISTIVO_VERSION);
    } else {
        wp_enqueue_style('listivo', get_stylesheet_uri(), $deps, LISTIVO_VERSION);
    }

    if (!class_exists(\Tangibledesign\Framework\Core\App::class)) {
        wp_enqueue_style('comfortaa-font',
            'https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&display=swap');
        wp_enqueue_style('inter-font',
            'https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap');

        wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/all.css');
        wp_enqueue_script('listivo-js', get_template_directory_uri() . '/assets/js/blog.min.js', ['jquery'],
            LISTIVO_VERSION, true);
    }
});

add_action('widgets_init', static function () {
    register_sidebar(
        [
            'name' => esc_html__('Listivo Sidebar', 'listivo'),
            'id' => 'listivo-sidebar',
            'description' => esc_html__('Add widgets here.', 'listivo'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h3 class="listivo-widget-title">',
            'after_title' => '</h3>',
        ]
    );
});

if (!\Tangibledesign\Framework\Core\App::class) {
    add_theme_support('automatic-feed-links');
}

if (!isset($content_width)) {
    $content_width = 900;
}