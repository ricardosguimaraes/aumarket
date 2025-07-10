<?php

add_filter('tdf/taxonomies', static function ($taxonomies) {
    return array_merge($taxonomies, [
        [
            'key' => 'listivo_currency',
            'object_type' => 'listivo_field',
            'label' => esc_html__('Currency', 'listivo-core'),
            'settings' => [
                'query_var' => false,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
            ]
        ]
    ]);
});