<?php

namespace Tangibledesign\Framework\Models\Template\TemplateType;

use Tangibledesign\Framework\Models\Template\PrintModelTemplate;
use Tangibledesign\Framework\Widgets\Helpers\PrintModelWidget;

class PrintModelTemplateType extends ModelSingleTemplateType
{
    public const TYPE = 'print_model';

    /**
     * @return string
     */
    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('print_model');
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
        return is_a($widgetClass, PrintModelWidget::class, true);
    }

    /**
     * @return string
     */
    public function getTemplateClass(): string
    {
        return PrintModelTemplate::class;
    }

}