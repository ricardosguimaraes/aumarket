<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Post\PostStatus;

class RegenerateModelTitlesServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/model/regenerate-titles', [$this, 'regenerateTitles']);
    }

    public function regenerateTitles(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die('Unauthorized', 403);
        }

        if (tdf_settings()->getAutoGenerateModelTitleFieldIds()->isEmpty()) {
            wp_die('No fields selected', 400);
        }

        $limit = (int)($_POST['limit'] ?? 50);
        $offset = (int)($_POST['offset'] ?? 0);

        $models = tdf_query_models()
            ->take($limit)
            ->skip($offset)
            ->status(PostStatus::ANY)
            ->get();
        if ($models->isEmpty()) {
            wp_die('No models found', 400);
        }

        foreach ($models as $model) {
            do_action(tdf_prefix() . '/model/update', $model, false);
        }
    }
}