<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use WP_Post;

class ModelMetaBoxServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('add_meta_boxes', [$this, 'addMetaBoxes'], 10, 2);
    }

    public function addMetaBoxes(string $postType, $post): void
    {
        if ($postType !== tdf_model_post_type()) {
            return;
        }

        if (!$post instanceof WP_Post || empty($post->post_status)) {
            return;
        }

        $model = new Model($post);

        add_meta_box(
            tdf_prefix() . '/model/metaBox',
            tdf_string('listing'),
            static function () use ($model) {
                tdf_load_view('model/meta_box', [
                    'model' => $model,
                ]);
            },
            tdf_model_post_type(),
            'side',
            'core'
        );
    }
}