<?php


namespace Tangibledesign\Framework\Models\Template\TemplateType;


use Tangibledesign\Framework\Models\Template\LayoutTemplate;
use Tangibledesign\Framework\Widgets\Helpers\LayoutWidget;

/**
 * Class LayoutTemplateType
 * @package Tangibledesign\Framework\Models\Template\TemplateType
 */
class LayoutTemplateType extends TemplateType
{
    public const TYPE = 'layout';

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('layout');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @param string $widgetClass
     * @return bool
     */
    public function isWidgetCompatible(string $widgetClass): bool
    {
        return is_a($widgetClass, LayoutWidget::class, true);
    }

    /**
     * @return string
     */
    public function getTemplateClass(): string
    {
        return LayoutTemplate::class;
    }

}