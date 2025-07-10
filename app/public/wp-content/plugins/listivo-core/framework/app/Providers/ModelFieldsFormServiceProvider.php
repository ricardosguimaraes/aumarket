<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Factories\PostFactory;
use Tangibledesign\Framework\Models\Field\RichTextField;
use WP_Post;

class ModelFieldsFormServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('add_meta_boxes', function (string $postType, $post) {
            if (!$post instanceof WP_Post || empty($post->post_status) || !in_array($post->post_type,
                    tdf_app('fieldable_post_types'), true)) {
                return;
            }

            $this->createForm($post);
        }, 10, 2);

        add_action('edit_form_after_editor', function ($post) {
            if (!$post instanceof WP_Post || empty($post->post_status) || !in_array($post->post_type,
                    tdf_app('fieldable_post_types'), true)) {
                return;
            }

            $this->richTextFields($post);
        });
    }

    public function richTextFields(WP_Post $post): void
    {
        $model = tdf_post_factory()->create($post);

        tdf_ordered_fields()->filter(static function ($field) {
            return $field instanceof RichTextField;
        })->each(function ($field) use ($model) {
            tdf_load_view('model/fields/rich_text', [
                tdf_short_prefix() . 'Field' => $field,
                tdf_short_prefix() . 'Model' => $model,
            ]);
        });
    }

    public function createForm(WP_Post $post): void
    {
        $model = (new PostFactory())->create($post);

        add_meta_box('tdfm-model', tdf_admin_string('attributes'), static function () use ($model) {
            tdf_load_view('model/fields', [
                tdf_short_prefix() . 'Model' => $model,
            ]);
        }, null, 'normal', 'high');
    }
}