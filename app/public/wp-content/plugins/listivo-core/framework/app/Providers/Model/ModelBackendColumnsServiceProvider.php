<?php

namespace Tangibledesign\Framework\Providers\Model;

use Tangibledesign\Framework\Core\ServiceProvider;

class ModelBackendColumnsServiceProvider extends ServiceProvider
{
    private const MODEL_VIEWS = 'model_views';
    private const MODEL_FAVORITES = 'model_favorites';
    private const MODEL_PHONE_REVEALS = 'model_phone_reveals';

    public function afterInitiation(): void
    {
        add_filter('manage_' . tdf_model_post_type() . '_posts_columns', [$this, 'addColumns']);
        add_action('manage_' . tdf_model_post_type() . '_posts_custom_column', [$this, 'columnValues'], 10, 2);
    }

    public function addColumns($initialColumns): array
    {
        $newColumns = [
            self::MODEL_VIEWS => tdf_admin_string('views'),
            self::MODEL_FAVORITES => tdf_admin_string('favorites'),
            self::MODEL_PHONE_REVEALS => tdf_admin_string('phone_reveals')
        ];

        $titleIndex = array_search('title', array_keys($initialColumns), true);

        return array_slice($initialColumns, 0, $titleIndex + 1, true)
            + $newColumns
            + array_slice($initialColumns, $titleIndex + 1, null, true);
    }

    public function columnValues($column, $modelId): void
    {
        $model = tdf_model_factory()->create($modelId);
        if (!$model) {
            return;
        }

        if ($column === self::MODEL_VIEWS) {
            echo $model->getViews();
        }

        if ($column === self::MODEL_FAVORITES) {
            echo $model->getFavoriteCount();
        }

        if ($column === self::MODEL_PHONE_REVEALS) {
            echo $model->getRevealPhoneCounter();
        }
    }
}