<?php

namespace Tangibledesign\Listivo\Providers\Blog;

use Tangibledesign\Framework\Core\ServiceProvider;

class BlogCardCssServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('listivo/dynamicCss', static function () {
            ob_start();

            $cardSize = tdf_app('blog_card_image_size');
            ?>
            .listivo-blog-post-card-v5__image img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }

            @media (max-width: <?php echo esc_html(tdf_app('tablet_breakpoint')); ?>) {
            .listivo-blog-post-card-v4__image img {
            aspect-ratio: <?php echo esc_html($cardSize['width']); ?> / <?php echo esc_html($cardSize['height']); ?>;
            }
            }
            <?php
            echo ob_get_clean();
        });
    }

}