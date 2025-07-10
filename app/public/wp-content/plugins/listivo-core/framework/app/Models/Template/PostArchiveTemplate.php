<?php


namespace Tangibledesign\Framework\Models\Template;


use Tangibledesign\Framework\Models\Template\Helpers\HasLayout;
use Tangibledesign\Framework\Models\Template\Helpers\HasLayoutInterface;

/**
 * Class PostArchiveTemplate
 * @package Tangibledesign\Framework\Models\Template
 */
class PostArchiveTemplate extends Template implements HasLayoutInterface
{
    use HasLayout;

    public function display(): void
    {
        $staticBlog = apply_filters('tdf/staticBlog', false);
        if ($staticBlog) {
            get_template_part('templates/blog/index');
        } else {
            parent::display();
        }

        if (is_singular(tdf_prefix() . '_template')) {
            the_content();
        }
    }

}