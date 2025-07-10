<?php

namespace Tangibledesign\Framework\Providers\Elementor;

use Elementor\Core\Files\CSS\Post;
use Tangibledesign\Framework\Core\ServiceProvider;

class ElementorCssLoaderServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'prepareCss'], 9999);
    }

    public function prepareCss(): void
    {
        $kit = tdf_current_kit();
        if (!$kit) {
            return;
        }

        $post = new Post($kit->get_main_id());
        $post->enqueue();
    }
}