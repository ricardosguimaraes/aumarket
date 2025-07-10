<?php

add_filter('tdf/settings', static function () {
    return new Tangibledesign\Listivo\Providers\Settings\Settings();
});