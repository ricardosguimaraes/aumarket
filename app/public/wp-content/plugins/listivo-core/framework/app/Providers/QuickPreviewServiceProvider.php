<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;

class QuickPreviewServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_nopriv_' . tdf_prefix() . '/model/preview', [$this, 'preview']);
        add_action('admin_post_' . tdf_prefix() . '/model/preview', [$this, 'preview']);
    }

    public function preview(): void
    {
        global ${tdf_short_prefix() . 'CurrentListing'};
        ${tdf_short_prefix() . 'CurrentListing'} = $this->getModel();
        if (!${tdf_short_prefix() . 'CurrentListing'}) {
            return;
        }

        get_template_part('templates/partials/quick_view');
    }

    /**
     * @return int
     */
    private function getModelId(): int
    {
        return (int)$_POST['modelId'];
    }

    /**
     * @return false|Model
     */
    private function getModel()
    {
        $model = tdf_post_factory()->create($this->getModelId());
        if (!$model instanceof Model) {
            return false;
        }

        return $model;
    }
}