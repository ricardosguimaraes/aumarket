<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Post\PostStatus;
use WP_Query;

class ModelServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['models_pending_count'] = static function () {
            return (new WP_Query([
                'post_type' => tdf_model_post_type(),
                'post_status' => PostStatus::PENDING,
                'posts_per_page' => -1,
                'fields' => 'ids',
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ]))->found_posts;
        };

        $this->container['model_post_types'] = static function () {
            return apply_filters(tdf_prefix() . '/models', []);
        };

        $this->container['model_post_type'] = static function () {
            return apply_filters(tdf_prefix() . '/model/postType', '');
        };

        $this->container['current_model'] = static function () {
            global ${tdf_short_prefix() . 'Model'};
            if (!${tdf_short_prefix() . 'Model'} instanceof Model) {
                return false;
            }

            return ${tdf_short_prefix() . 'Model'};
        };

        $this->container['models_count'] = static function () {
            $count = wp_count_posts(tdf_model_post_type());

            $sum = 0;

            foreach ($count as $number) {
                $sum += $number;
            }

            return $sum;
        };
    }

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/model/delete', [$this, 'delete']);

        add_action('wp_insert_post_data', [$this, 'checkSlugForPending'], 10, 2);
    }

    public function checkSlugForPending(array $data, array $oldData): array
    {
        if ($data['post_type'] !== tdf_model_post_type()) {
            return $data;
        }

        if ($data['post_status'] !== PostStatus::PENDING) {
            return $data;
        }

        if (!empty($data['post_name']) || empty($oldData['post_name'])) {
            return $data;
        }

        $data['post_name'] = $oldData['post_name'];

        return $data;
    }

    public function delete(): void
    {
        $modelId = (int)$_POST['modelId'];
        if (!wp_verify_nonce($_POST['nonce'], 'delete_model_' . $modelId)) {
            $this->errorJsonResponse();
            return;
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            $this->errorJsonResponse();
            return;
        }

        if (!current_user_can('manage_options') && $model->getUserId() !== get_current_user_id()) {
            $this->errorJsonResponse();
            return;
        }

        wp_delete_post($modelId, true);

        $this->successJsonResponse();
    }
}