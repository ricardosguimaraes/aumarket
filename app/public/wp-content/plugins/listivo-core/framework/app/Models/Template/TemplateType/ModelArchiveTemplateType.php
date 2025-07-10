<?php

namespace Tangibledesign\Framework\Models\Template\TemplateType;

use Tangibledesign\Framework\Models\Template\ModelArchiveTemplate;
use Tangibledesign\Framework\Widgets\Helpers\ModelArchiveWidget;

class ModelArchiveTemplateType extends TemplateType
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_app('model_archive_template_name');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return tdf_app('model_archive_template_type');
    }

    /**
     * @param string $widgetClass
     * @return bool
     */
    public function isWidgetCompatible(string $widgetClass): bool
    {
        return is_a($widgetClass, ModelArchiveWidget::class, true);
    }

    /**
     * @return string
     */
    public function getTemplateClass(): string
    {
        return ModelArchiveTemplate::class;
    }

}