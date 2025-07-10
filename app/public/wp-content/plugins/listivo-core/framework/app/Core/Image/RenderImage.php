<?php

namespace Tangibledesign\Framework\Core\Image;

use Tangibledesign\Framework\Models\Image;

class RenderImage
{
    /**
     * @param Image|false $image
     * @param string $size
     * @return void
     */
    public static function render($image, string $size): void
    {
        global ${tdf_short_prefix() . 'TempImage'}, ${tdf_short_prefix() . 'ImageSize'};

        ${tdf_short_prefix() . 'TempImage'} = $image;
        ${tdf_short_prefix() . 'ImageSize'} = $size;

        get_template_part('templates/partials/image');

        ${tdf_short_prefix() . 'TempImage'} = null;
        ${tdf_short_prefix() . 'ImageSize'} = null;
    }

}