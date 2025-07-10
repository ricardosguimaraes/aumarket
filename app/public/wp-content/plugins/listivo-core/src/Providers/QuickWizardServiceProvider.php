<?php

namespace Tangibledesign\Listivo\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class QuickWizardServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_menu', [$this, 'addMenuItem']);
    }

    public function addMenuItem(): void
    {
        add_submenu_page(
            tdf_prefix().'_hidden',
            esc_html__('Quick Wizard', 'listivo-core'),
            esc_html__('Quick Wizard', 'listivo-core'),
            'manage_options',
            tdf_app('prefix').'-quick-wizard',
            static function () {
                require tdf_app('path').'views/dashboard/quick_wizard.php';
            }
        );
    }

}