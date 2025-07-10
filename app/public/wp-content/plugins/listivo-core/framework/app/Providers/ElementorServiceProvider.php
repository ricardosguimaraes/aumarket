<?php

namespace Tangibledesign\Framework\Providers;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class ElementorServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('elementor/controls/register', [$this, 'registerWidgetControls']);

        add_action('wp_footer', static function () {
            if (Plugin::$instance->preview->is_preview_mode()) {
                wp_enqueue_script(tdf_prefix() . '-elementor-editor', tdf_app('url') . '/framework/assets/js/elementorEditor.js', ['jquery'],
                    tdf_app('version'));
            }
        });
    }

    public function registerWidgetControls(Controls_Manager $controlsManager): void
    {
        $controlsManager->register(new SelectRemoteControl());
    }
}