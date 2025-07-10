<?php



add_filter('listivo/model/slug', function () {
    return tdf_slug('listing');
});

add_filter('listivo/model/archiveSlug', function () {
    return tdf_slug('listings');
});

add_filter('listivo/model/postType', function () {
    return 'listivo_listing';
});

add_filter('listivo/models', function () {
    return [
        tdf_model_post_type(),
    ];
});