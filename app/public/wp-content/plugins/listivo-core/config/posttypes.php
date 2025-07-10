<?php


add_filter('tdf/posttypes', static function ($postTypesData) {
    return array_merge($postTypesData, [
        [
            'key' => tdf_prefix() . '_field',
            'name' => esc_html__('Fields', 'listivo-core'),
            'singular_name' => esc_html__('Field', 'listivo-core'),
            'settings' => [
                'public' => false,
                'show_ui' => true,
                'show_in_menu' => tdf_app('slug'),
                'menu_position' => 3,
                'has_archive' => false,
                'hierarchical' => false,
                'taxonomies' => [],
                'map_meta_cap' => true,
                'capability_type' => 'post',
                'supports' => ['title'],
                'query_var' => true,
                'publicly_queryable' => true,
            ]
        ],
        [
            'key' => tdf_prefix() . '_template',
            'name' => esc_html__('Templates', 'listivo-core'),
            'singular_name' => esc_html__('Template', 'listivo-core'),
            'settings' => [
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => tdf_app('slug'),
                'menu_position' => 3,
                'has_archive' => false,
                'hierarchical' => false,
                'taxonomies' => [],
                'map_meta_cap' => true,
                'capability_type' => 'post',
                'supports' => ['title'],
                'query_var' => true,
                'publicly_queryable' => true,
            ]
        ],
        [
            'key' => tdf_model_post_type(),
            'name' => tdf_string('listings'),
            'singular_name' => esc_html__('Listing', 'listivo-core'),
            'settings' => [
                'public' => true,
                'show_ui' => true,
                'menu_position' => 2,
                'has_archive' => tdf_slug('listings'),
                'hierarchical' => false,
                'taxonomies' => [],
                'map_meta_cap' => true,
                'capability_type' => 'post',
                'supports' => ['title', 'author', 'editor'],
                'query_var' => true,
                'publicly_queryable' => true,
                'rewrite' => [
                    'slug' => tdf_slug('listing'),
                    'with_front' => false,
                ],
                'show_in_rest' => true,
                'rest_base' => 'listings',
            ]
        ],
        [
            'key' => tdf_prefix() . '_package',
            'name' => esc_html__('Payment Packages', 'listivo-core'),
            'singular_name' => esc_html__('Payment Package', 'listivo-core'),
            'settings' => [
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => false,
                'show_in_menu' => false,
                'query_var' => false,
                'has_archive' => false,
                'hierarchical' => false,
                'supports' => ['title'],
            ]
        ],
        [
            'key' => tdf_prefix() . '_user_package',
            'name' => esc_html__('User Payment Packages', 'listivo-core'),
            'singular_name' => esc_html__('User Payment Package', 'listivo-core'),
            'settings' => [
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => false,
                'show_in_menu' => false,
                'query_var' => false,
                'has_archive' => false,
                'hierarchical' => false,
                'supports' => ['title'],
            ]
        ],
        [
            'key' => tdf_prefix() . '_order',
            'name' => esc_html__('Order', 'listivo-core'),
            'singular_name' => esc_html__('Order', 'listivo-core'),
            'settings' => [
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => false,
                'show_in_menu' => false,
                'query_var' => false,
                'has_archive' => false,
                'hierarchical' => false,
                'supports' => ['title'],
            ]
        ],
        [
            'key' => tdf_prefix() . '_notify',
            'name' => esc_html__('Notifications', 'listivo-core'),
            'singular_name' => esc_html__('Notification', 'listivo-core'),
            'settings' => [
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => false,
                'show_in_menu' => false,
                'query_var' => false,
                'has_archive' => false,
                'hierarchical' => false,
                'supports' => ['title'],
            ]
        ],
        [
            'key' => tdf_prefix() . '_notify_task',
            'name' => esc_html__('Notifications (Tasks)', 'listivo-core'),
            'singular_name' => esc_html__('Notification (Task)', 'listivo-core'),
            'settings' => [
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => false,
                'show_in_menu' => false,
                'query_var' => false,
                'has_archive' => false,
                'hierarchical' => false,
                'supports' => ['title'],
            ]
        ],
        [
            'key' => tdf_prefix() . '_review',
            'name' => esc_html__('Reviews', 'listivo-core'),
            'singular_name' => esc_html__('Review', 'listivo-core'),
            'settings' => [
                'menu_position' => 4,
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'query_var' => false,
                'has_archive' => false,
                'hierarchical' => false,
                'taxonomies' => [],
                'map_meta_cap' => true,
                'capability_type' => 'post',
                'supports' => ['author', 'editor'],
                'show_in_rest' => true,
                'rest_base' => 'reviews',
            ]
        ]
    ]);
});