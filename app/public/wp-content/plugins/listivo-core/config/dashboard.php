<?php

add_filter('tdf/admin/dashboard', function () {
    return [
        'name' => esc_html__('Listivo Panel', 'listivo-core'),
        'slug' => 'listivo_basic_setup',
        'items' => [
            [
                'name' => esc_html__('Settings', 'listivo-core'),
                'slug' => 'basic_setup',
            ],
            [
                'name' => esc_html__('Global Design', 'listivo-core'),
                'slug' => 'design',
            ],
            [
                'name' => esc_html__('User Panel', 'listivo-core'),
                'slug' => 'user_panel',
            ],
            [
                'name' => esc_html__('Monetization', 'listivo-core'),
                'slug' => 'monetization',
            ],
            [
                'name' => esc_html__('Templates', 'listivo-core'),
                'slug' => 'templates',
            ],
            [
                'name' => esc_html__('Custom Fields', 'listivo-core'),
                'slug' => 'custom_fields',
            ],
            [
                'name' => esc_html__('Notifications', 'listivo-core'),
                'slug' => 'notifications',
            ],
            [
                'name' => esc_html__('Translate/Rename', 'listivo-core'),
                'slug' => 'translate_and_rename',
            ],
            [
                'name' => esc_html__('Advanced', 'listivo-core'),
                'slug' => 'advanced',
            ],
        ]
    ];
});