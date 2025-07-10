<?php


namespace Tangibledesign\Framework\Widgets\Helpers;


use Tangibledesign\Framework\Models\BlogPost;

/**
 * Trait HasBlogPost
 * @package Tangibledesign\Framework\Widgets\Helpers
 */
trait HasBlogPost
{
    /**
     * @return BlogPost|false
     */
    public function getBlogPost()
    {
        global ${tdf_short_prefix() . 'BlogPost'};

        if (!${tdf_short_prefix() . 'BlogPost'}) {
            return false;
        }

        return ${tdf_short_prefix() . 'BlogPost'};
    }

}