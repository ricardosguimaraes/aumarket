<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Page;
use Tangibledesign\Framework\Queries\QueryPages;

class PageServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['query_pages'] = $this->container->factory(static function () {
            return new QueryPages();
        });

        $this->container['pages'] = static function ($c) {
            return $c['query_pages']->get();
        };
    }

    public function afterInitiation(): void
    {
        add_action('save_post_page', [$this, 'setLayout']);

        add_filter('body_class', [$this, 'bodyClass']);
    }

    public function bodyClass($classes): array
    {
        global $post;
        $page = tdf_post_factory()->create($post);
        if (!$page instanceof Page) {
            return $classes;
        }

        if ($page->hasTransparentMenu()) {
            $classes[] = tdf_prefix() . '-menu-transparent';
        }

        return $classes;
    }

    /**
     * @param int $pageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setLayout($pageId): void
    {
        remove_action('save_post_page', [$this, 'setLayout']);

        $page = tdf_post_factory()->create($pageId);
        if (!$page) {
            return;
        }

        $layoutId = $page->getLayoutId();
        if (empty($layoutId) && tdf_app('default_layout')) {
            /** @noinspection NullPointerExceptionInspection */
            $page->setLayoutId(tdf_app('default_layout')->getId());
        }
    }
}