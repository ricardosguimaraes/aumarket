<?php



add_filter('tdf/fieldable/postTypes', static function ($postTypes) {
    $postTypes[] = tdf_model_post_type();

    return $postTypes;
});