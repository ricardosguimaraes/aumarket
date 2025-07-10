<?php

namespace Tangibledesign\Framework\Models\Template;

use Elementor\Plugin;
use WP_Post;

class LayoutTemplate extends Template
{
    public function display(): void
    {
        global $post;

        if ($post instanceof WP_Post && $post->ID === $this->getId() && is_singular(tdf_prefix() . '_template')) {
            echo apply_filters('the_content', $this->post->post_content);
            return;
        }

        setup_postdata($this->post);
        echo Plugin::instance()->frontend->get_builder_content_for_display($this->getId());
        wp_reset_postdata();
    }
}