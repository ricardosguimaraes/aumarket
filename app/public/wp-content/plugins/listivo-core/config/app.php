<?php

use Tangibledesign\Listivo\Widgets\Helpers\PostsWidget;

add_filter('tdf/prefix', function () {
    return 'listivo';
});

add_filter('tdf/shortPrefix', function () {
    return 'lst';
});

add_filter('tdf/config', function () {
    return [
        'name' => esc_html__('Listivo', 'listivo-core'),
        'prefix' => 'listivo',
        'slug' => 'listivo',
        'url' => LISTIVO_URL,
        'path' => LISTIVO_PATH,
        'version' => LISTIVO_CORE_VERSION,
        'model_card_default_image_size' => 'listivo_720_540',
        'model_row_default_image_size' => 'listivo_720_540',
        'compare_model_image_size' => 'listivo_360_240',
    ];
});

add_filter('tdf/wpAllImporter/imagesDocUrl', static function () {
    return 'https://support.listivotheme.com/support/solutions/articles/101000373811';
});

add_filter('tdf/wpAllImporter/parentChildDocUrl', static function () {
    return 'https://support.listivotheme.com/support/solutions/articles/101000373816';
});

add_filter('tdf/wp/widgets', static function () {
    return [
        PostsWidget::class,
    ];
});