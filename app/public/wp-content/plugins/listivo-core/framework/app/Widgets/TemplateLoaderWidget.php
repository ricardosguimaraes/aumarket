<?php

namespace Tangibledesign\Framework\Widgets;

use Elementor\Plugin;
use Tangibledesign\Framework\Factories\TemplateFactory;
use Tangibledesign\Framework\Models\Template\LayoutTemplate;
use Tangibledesign\Framework\Models\Template\PostArchiveTemplate;
use Tangibledesign\Framework\Models\Template\PostSingleTemplate;
use Tangibledesign\Framework\Widgets\Helpers\GeneralWidget;

class TemplateLoaderWidget extends Widget implements GeneralWidget
{
    public function getKey(): string
    {
        return 'template_loader';
    }

    public function getName(): string
    {
        return tdf_admin_string('template_loader');
    }

    protected function renderContent(): void
    {
        if (is_singular('page')) {
            $this->renderPage();
            return;
        }

        if (is_singular('attachment')) {
            $this->renderAttachment();
            return;
        }

        if (is_404()) {
            the_content();
            return;
        }
        
        if (is_singular(tdf_prefix() . '_template')) {
            $this->renderTemplatePostType();
            return;
        }

        $this->renderTemplate();
    }

    private function renderTemplate(): void
    {
        $templateType = tdf_template_type_factory()->getCurrent();
        if (!$templateType) {
            return;
        }

        $template = $templateType->getDefaultTemplate();

        if ($template instanceof PostSingleTemplate || $template instanceof PostArchiveTemplate) {
            $template->display();
            return;
        }

        if ($template && (!defined('DOING_AJAX') || !DOING_AJAX)) {
            echo Plugin::instance()->frontend->get_builder_content_for_display($template->getId());
        }
    }

    private function renderAttachment(): void
    {
        get_template_part('templates/attachment');
    }

    private function renderPage(): void
    {
        global $post;
        echo apply_filters('the_content', $post->post_content);
    }

    private function renderTemplatePostType(): void
    {
        global $post;
        $template = TemplateFactory::make()->create($post);
        if ($template instanceof LayoutTemplate) {
            tdf_load_view('templates/template_placeholder');
        } else {
            the_content();
        }
    }
}