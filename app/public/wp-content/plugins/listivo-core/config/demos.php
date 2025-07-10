<?php

use Tangibledesign\Framework\Core\Demo;

add_filter('listivo/demoImporter/sourceUrl', static function () {
    if (defined('LISTIVO_DEV') && LISTIVO_DEV) {
        return 'https://files.tangiblewp.com/listivo/devDemo';
    }

    return 'https://files.tangiblewp.com/listivo/demo';
});

add_filter('listivo/demoImporter/demos', static function () {
    return [
        [
            Demo::KEY => 'demo3',
            Demo::NAME => esc_html__('Demo Modern', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/modern.png',
            Demo::MEDIA_SOURCE => 'https://demo3.listivotheme.com',
            Demo::URL => 'https://demo3.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo7',
            Demo::NAME => esc_html__('Demo Classic', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/classic.png',
            Demo::MEDIA_SOURCE => 'https://demo7.listivotheme.com',
            Demo::URL => 'https://demo7.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo8',
            Demo::NAME => esc_html__('Demo Abstract', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/abstract.png',
            Demo::MEDIA_SOURCE => 'https://demo8.listivotheme.com',
            Demo::URL => 'https://demo8.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo5',
            Demo::NAME => esc_html__('Demo Automotive', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/automotive.png',
            Demo::MEDIA_SOURCE => 'https://demo5.listivotheme.com',
            Demo::URL => 'https://demo5.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo4',
            Demo::NAME => esc_html__('Demo Real Estate', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/real-estate.png',
            Demo::MEDIA_SOURCE => 'https://demo4.listivotheme.com',
            Demo::URL => 'https://demo4.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo9',
            Demo::NAME => esc_html__('Demo Realtor', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/realtor.png',
            Demo::MEDIA_SOURCE => 'https://demo9.listivotheme.com',
            Demo::URL => 'https://demo9.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo10',
            Demo::NAME => esc_html__('Demo Earth Tones', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/earth-tones.png',
            Demo::MEDIA_SOURCE => 'https://demo10.listivotheme.com',
            Demo::URL => 'https://demo10.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo11',
            Demo::NAME => esc_html__('Demo Cars', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/car-luxury.png',
            Demo::MEDIA_SOURCE => 'https://demo11.listivotheme.com',
            Demo::URL => 'https://demo11.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo13',
            Demo::NAME => esc_html__('Demo Transparent Blue', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/transparent-blue.jpg',
            Demo::MEDIA_SOURCE => 'https://demo13.listivotheme.com',
            Demo::URL => 'https://demo13.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo14',
            Demo::NAME => esc_html__('Demo Comfort', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/comfort.jpg',
            Demo::MEDIA_SOURCE => 'https://demo14.listivotheme.com',
            Demo::URL => 'https://demo14.listivotheme.com'
        ],
        [
            Demo::KEY => 'demo6',
            Demo::NAME => esc_html__('Demo Services', 'listivo-core'),
            Demo::IMAGE => 'https://files.tangiblewp.com/listivo/demo-importer-previews/services-new.jpg',
            Demo::MEDIA_SOURCE => 'https://demo6.listivotheme.com',
            Demo::URL => 'https://demo6.listivotheme.com'
        ],
    ];
});