<?php



add_filter('tdf/templatable/postTypes', static function ($postTypes) {
    $postTypes[] = tdf_model_post_type();

    return $postTypes;
});