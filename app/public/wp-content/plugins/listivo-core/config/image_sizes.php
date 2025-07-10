<?php

add_filter('listivo/images/sizes', static function () {
    return [
        [
            'key' => 'listivo_100_100',
            'width' => 100,
            'height' => 100,
            'crop' => true,
        ],
        [
            'key' => 'listivo_400_400',
            'width' => 400,
            'height' => 400,
            'crop' => true,
        ],
        [
            'key' => 'listivo_360_320',
            'width' => 360,
            'height' => 320,
            'crop' => true,
        ],
        [
            'key' => 'listivo_720_640',
            'width' => 720,
            'height' => 640,
            'crop' => true,
        ],
        [
            'key' => 'listivo_360_240',
            'width' => 360,
            'height' => 240,
            'crop' => true,
        ],
        [
            'key' => 'listivo_720_480',
            'width' => 720,
            'height' => 480,
            'crop' => true,
        ],
        [
            'key' => 'listivo_750_500',
            'width' => 750,
            'height' => 500,
            'crop' => true,
        ]
    ];
});