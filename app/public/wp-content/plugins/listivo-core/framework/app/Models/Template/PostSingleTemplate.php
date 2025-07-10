<?php


namespace Tangibledesign\Framework\Models\Template;


use Tangibledesign\Framework\Models\Template\Helpers\HasLayout;
use Tangibledesign\Framework\Models\Template\Helpers\HasLayoutInterface;

/**
 * Class PostSingleTemplate
 * @package Tangibledesign\Framework\Models\Template
 */
class PostSingleTemplate extends Template implements HasLayoutInterface
{
    use HasLayout;

    public function display(): void
    {
        $staticBlog = apply_filters('tdf/staticBlog', false);
        if ($staticBlog) {
            get_template_part('templates/blog/single');
        } else {
            parent::display();
        }
    }

}