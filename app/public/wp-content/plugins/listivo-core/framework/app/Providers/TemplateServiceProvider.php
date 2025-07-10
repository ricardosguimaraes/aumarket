<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Template\LayoutTemplate;
use Tangibledesign\Framework\Models\Template\Template;
use Tangibledesign\Framework\Models\Template\TemplateType\LayoutTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\ModelArchiveTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\ModelSingleTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\PostArchiveTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\PostSingleTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\PrintModelTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\UserTemplateType;

class TemplateServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['template_types_list'] = static function () {
            return apply_filters(tdf_prefix().'/templates/types', [
                LayoutTemplateType::class,
                ModelSingleTemplateType::class,
                ModelArchiveTemplateType::class,
                PrintModelTemplateType::class,
                UserTemplateType::class,
                PostSingleTemplateType::class,
                PostArchiveTemplateType::class,
            ]);
        };

        $this->container['template_types'] = static function () {
            return tdf_collect(tdf_app('template_types_list'))
                ->map(static function ($class) {
                    return new $class;
                });
        };

        $this->container['templates'] = static function () {
            return tdf_query_templates()->get()
                ->filter(static function ($template) {
                    return $template !== false;
                });
        };

        $this->container['layouts'] = static function () {
            /** @noinspection NullPointerExceptionInspection */
            return tdf_app('templates')
                ->filter(static function (Template $template) {
                    return $template instanceof LayoutTemplate;
                });
        };

        $this->container['default_layout'] = static function () {
            $defaultTemplates = tdf_settings()->getDefaultTemplates();

            if (!isset($defaultTemplates['layout']) || empty($defaultTemplates)) {
                /** @noinspection NullPointerExceptionInspection */
                return tdf_app('layouts')->isEmpty() ? false : tdf_app('layouts')->first();
            }

            $layoutId = (int)$defaultTemplates['layout'];
            /** @noinspection NullPointerExceptionInspection */
            $layout = tdf_app('layouts')
                ->find(static function ($layout) use ($layoutId) {
                    /* @var LayoutTemplate $layout */
                    return $layout->getId() === $layoutId;
                });

            if ($layout) {
                return $layout;
            }

            /** @noinspection NullPointerExceptionInspection */
            return tdf_app('layouts')->isEmpty() ? false : tdf_app('layouts')->first();
        };
    }
}