<?php

namespace Tangibledesign\Framework\Providers;

use Elementor\Plugin;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Factories\TemplateFactory;
use Tangibledesign\Framework\Models\Template\Helpers\HasLayoutInterface;
use Tangibledesign\Framework\Models\Template\LayoutTemplate;
use Tangibledesign\Framework\Models\Template\Template;

class TemplateLoaderServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['current_template'] = function () {
            return $this->getTemplate();
        };
    }

    public function afterInitiation(): void
    {
        add_filter('body_class', static function ($classes) {
            $template = tdf_app('current_template');
            if (!$template instanceof Template) {
                return $classes;
            }

            if ($template->hasTransparentMenu()) {
                $classes[] = tdf_prefix() . '-menu-transparent';
            }

            return $classes;
        });

        add_action(tdf_prefix() . '/templates/render', [$this, 'render']);
    }

    public function render(): void
    {
        $template = tdf_app('current_template');
        if (!$template) {
            the_content();
            return;
        }

        if (!$template instanceof HasLayoutInterface) {
            $template->display();
            return;
        }

        $layout = $template->getLayout();
        if (!$layout) {
            $template->display();
            return;
        }

        $layout->display();
    }

    /**
     * @return Template|false
     */
    private function getTemplate()
    {
        if (is_page() || is_404()) {
            return $this->getPageLayout();
        }

        $templateType = tdf_template_type_factory()->getCurrent();
        if (!$templateType) {
            return false;
        }

        if (!is_singular(tdf_prefix() . '_template')) {
            $templateType->prepare();
        }

        if (!is_singular(tdf_prefix() . '_template')) {
            return $templateType->getDefaultTemplate();
        }

        global $post;
        return TemplateFactory::make()->create($post);
    }

    /**
     * @return LayoutTemplate|false
     */
    private function getPageLayout()
    {
        global $post;

        if (is_404()) {
            $id = tdf_settings()->getErrorPageId();
            $post = get_post($id);
        }

        if (!$post) {
            return false;
        }

        $document = Plugin::instance()->documents->get($post->ID);
        $layoutId = (int)$document->get_settings('tdf_layout');

        if (empty($layoutId)) {
            return tdf_app('default_layout') ?? false;
        }

        $layout = tdf_template_factory()->create($layoutId);
        if (!$layout instanceof LayoutTemplate) {
            return false;
        }

        return $layout;
    }
}