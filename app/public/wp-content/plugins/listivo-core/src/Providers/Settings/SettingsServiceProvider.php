<?php

namespace Tangibledesign\Listivo\Providers\Settings;

use Tangibledesign\Framework\Core\ServiceProvider;

class SettingsServiceProvider extends ServiceProvider
{
    public const TYPE_BASIC = 'basic';
    public const TYPE_ADVANCED = 'advanced';
    public const TYPE_USER_PANEL = 'user_panel';
    public const TYPE_NOTIFICATIONS = 'notifications';
    public const TYPE_DESIGN = 'design';
    public const TYPE_QUICK_WIZARD = 'quick_wizard';
    public const TYPE_MONETIZATION = 'monetization';

    public function afterInitiation(): void
    {
        add_action('admin_post_listivo/settings/save', [$this, 'save']);
    }

    public function save(): void
    {
        $settingsType = $_REQUEST['type'] ?? '';

        do_action(
            'tdf/settings/save',
            $this->getSettingKeys($settingsType),
            $_POST
        );

        do_action(tdf_prefix().'/urls/flush');

        do_action(tdf_prefix().'/paymentPackages/synchronize');

        do_action('tdf/settings/saved', $settingsType);

        wp_safe_redirect($_POST['redirect'] ?? site_url());
        exit;
    }

    /**
     * @param  string  $type
     * @return array
     */
    private function getSettingKeys(string $type): array
    {
        if ($type === self::TYPE_BASIC) {
            return Settings::getBasicSettings();
        }

        if ($type === self::TYPE_USER_PANEL) {
            return Settings::getUserPanelSettings();
        }

        if ($type === self::TYPE_NOTIFICATIONS) {
            return Settings::getNotificationSettings();
        }

        if ($type === self::TYPE_ADVANCED) {
            return Settings::getAdvancedSettings();
        }

        if ($type === self::TYPE_DESIGN) {
            return Settings::getDesignSettings();
        }

        if ($type === self::TYPE_QUICK_WIZARD) {
            return Settings::getQuickWizardSettings();
        }

        if ($type === self::TYPE_MONETIZATION) {
            return Settings::getMonetizationSettings();
        }

        return [];
    }

}