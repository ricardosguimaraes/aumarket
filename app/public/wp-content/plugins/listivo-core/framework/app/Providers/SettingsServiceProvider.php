<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class SettingsServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class SettingsServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['settings'] = static function () {
            return apply_filters('tdf/settings', null);
        };
    }

    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/translateRename/save', static function () {
            if (!current_user_can('manage_options')) {
                return;
            }

            do_action(tdf_prefix().'/strings/save');

            do_action(tdf_prefix().'/slugs/save');

            do_action(tdf_prefix().'/urls/flush');

            wp_redirect(admin_url('admin.php?page='.tdf_prefix().'_translate_and_rename'));
            exit;
        });
    }

}