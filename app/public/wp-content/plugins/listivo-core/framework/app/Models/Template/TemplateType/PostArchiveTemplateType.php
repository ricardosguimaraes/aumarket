<?php


namespace Tangibledesign\Framework\Models\Template\TemplateType;


use Tangibledesign\Framework\Models\Template\PostArchiveTemplate;
use Tangibledesign\Framework\Widgets\Helpers\PostArchiveWidget;

/**
 * Class PostArchiveTemplateType
 * @package Tangibledesign\Framework\Models\Template\TemplateType
 */
class PostArchiveTemplateType extends TemplateType
{
    public const TYPE = 'post_archive';

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('post_archive');
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
        return is_a($widgetClass, PostArchiveWidget::class, true);
    }

    /**
     * @return string
     */
    public function getTemplateClass(): string
    {
        return PostArchiveTemplate::class;
    }

}