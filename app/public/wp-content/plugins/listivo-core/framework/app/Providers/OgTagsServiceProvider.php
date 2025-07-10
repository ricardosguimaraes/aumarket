<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use WP_Post;

class OgTagsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('wp_head', function () {
            if (!is_singular(tdf_model_post_type())) {
                return;
            }

            $this->renderModelTags();
        });
    }

    private function renderModelTags(): void
    {
        $model = tdf_current_model();
        if (!$model) {
            global $post;
            if (!$post instanceof WP_Post || $post->post_type !== tdf_model_post_type()) {
                return;
            }

            $model = new Model($post);
        }
        ?>
        <meta property="og:title" content="<?php echo esc_attr($model->getName()); ?>"/>
        <meta property="og:description" content="<?php echo esc_attr($model->getExcerpt()); ?>"/>
        <?php
        if ($model->hasMainImage()) : ?>
            <meta property="og:image" content="<?php echo esc_url($model->getMainImageUrl()); ?>"/>
        <?php
        endif;
    }

}