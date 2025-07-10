<?php

namespace Tangibledesign\Framework\Core\Image;

use Tangibledesign\Framework\Models\User\User;

class RenderUserImage
{
    public const PLACEHOLDER_CIRCLE = 'circle';

    /**
     * @param User $user
     * @param string $size
     * @param string $placeholderType
     * @return void
     */
    public static function render(User $user, string $size = 'full', string $placeholderType = 'default'): void
    {
        global ${tdf_short_prefix() . 'TempUser'}, ${tdf_short_prefix() . 'ImageSize'};

        ${tdf_short_prefix() . 'TempUser'} = $user;
        ${tdf_short_prefix() . 'ImageSize'} = $size;
        ${tdf_short_prefix() . 'PlaceHolderType'} = $placeholderType;

        get_template_part('templates/partials/user_image');

        ${tdf_short_prefix() . 'TempUser'} = null;
        ${tdf_short_prefix() . 'ImageSize'} = null;
        ${tdf_short_prefix() . 'PlaceHolderType'} = null;
    }

}