<?php

namespace Tangibledesign\Framework\Providers;

use Elementor\Plugin;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;
use Tangibledesign\Framework\Widgets\Helpers\GeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\LayoutWidget;

class RegisterWidgetsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('elementor/widgets/register', [$this, 'register']);

        add_action('elementor/elements/categories_registered', [$this, 'registerCategories']);
    }

    public function registerCategories(): void
    {
        Plugin::instance()->elements_manager->add_category(
            tdf_prefix(),
            [
                'title' => tdf_app('name'),
                'icon' => ''
            ]
        );

        Plugin::instance()->elements_manager->add_category(
            tdf_prefix() . '_model',
            [
                'title' => tdf_app('name') . ' - ' . tdf_admin_string('model_single'),
                'icon' => ''
            ]
        );

        Plugin::instance()->elements_manager->add_category(
            tdf_prefix() . '_user',
            [
                'title' => tdf_app('name') . ' - ' . tdf_admin_string('user_page'),
                'icon' => ''
            ]
        );

        Plugin::instance()->elements_manager->add_category(
            tdf_prefix() . '_blog_post',
            [
                'title' => tdf_app('name') . ' - ' . tdf_admin_string('blog_post'),
                'icon' => ''
            ]
        );
    }

    public function register(): void
    {
        if (
            (isset($_POST['library_action']) && $_POST['library_action'] === 'direct_import_template')
            && current_user_can('manage_options')
        ) {
            $this->registerAll();

            return;
        }

        $templateType = tdf_template_type_factory()->getCurrent();
        if (!$templateType) {
            $this->registerOnlyGeneral();
            return;
        }

        $this->registerByTemplateType($templateType);
    }

    private function registerAll(): void
    {
        foreach ($this->getWidgetClasses() as $widgetClass) {
            Plugin::instance()->widgets_manager->register(new $widgetClass);
        }
    }

    private function registerOnlyGeneral(): void
    {
        foreach ($this->getWidgetClasses() as $widgetClass) {
            if ($this->isGeneralWidget($widgetClass)) {
                Plugin::instance()->widgets_manager->register(new $widgetClass);
            }
        }
    }

    private function registerByTemplateType(TemplateType $templateType): void
    {
        foreach ($this->getWidgetClasses() as $widgetClass) {
            if ($this->isGeneralWidget($widgetClass) || $templateType->isWidgetCompatible($widgetClass)) {
                Plugin::instance()->widgets_manager->register(new $widgetClass);
            }
        }
    }

    private function getWidgetClasses(): array
    {
        return apply_filters('tdf/widgets', []);
    }

    private function isGeneralWidget(string $widgetClass): bool
    {
        return is_a($widgetClass, GeneralWidget::class, true)
            || is_a($widgetClass, LayoutWidget::class, true);
    }
}