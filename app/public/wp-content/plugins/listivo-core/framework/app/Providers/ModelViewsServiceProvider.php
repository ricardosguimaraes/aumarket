<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Helpers\HasViewsInterface;

/**
 * Class ModelViewsServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class ModelViewsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('wp_head', [$this, 'increaseViews']);
    }

    public function increaseViews(): void
    {
        if (!is_singular()) {
            return;
        }

        global $post;
        if (!$post) {
            return;
        }

        $hasViews = tdf_post_factory()->create($post);
        if (!$hasViews instanceof HasViewsInterface) {
            return;
        }

        $hasViews->increase();
    }

}