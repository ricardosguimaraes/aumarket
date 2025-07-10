<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Models\Field\Fieldable;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use WP_Post;

class FieldableSaveValuesServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['fieldable_post_types'] = static function () {
            return apply_filters('tdf/fieldable/postTypes', []);
        };
    }

    public function afterInitiation(): void
    {
        add_action('save_post', [$this, 'beforeSave'], 10, 2);
    }

    public function beforeSave(int $postId, WP_Post $post): void
    {
        if (wp_is_post_revision($post) || !in_array($post->post_type, tdf_app('fieldable_post_types'), true)) {
            return;
        }

        $nonce = $_POST[tdf_prefix() . '_nonce'] ?? '';
        if (!wp_verify_nonce($nonce, tdf_prefix() . '_save_model')) {
            return;
        }

        remove_action('save_post', [$this, 'beforeSave']);

        $this->save($post);
    }

    public function save(WP_Post $post): void
    {
        $model = tdf_post_factory()->create($post);

        if (!$model instanceof Fieldable) {
            return;
        }

        $model->setExpireDate($_POST['model_expire'] ?? '');
        $model->setFeaturedExpireDate($_POST['model_featured_expire'] ?? '');
        $model->setViews((int)($_POST[Model::VIEWS] ?? 0));
        $model->setRevealPhoneCounter((int)($_POST[Model::PHONE_REVEALS] ?? 0));
        $model->setFavoriteCount((int)($_POST[Model::FAVORITE_COUNT] ?? 0));

        foreach (tdf_fields() as $field) {
            $field->setValue($model, $_POST[$field->getKey()] ?? '');
        }

        do_action(tdf_prefix() . '/model/update', $model, true);
    }
}