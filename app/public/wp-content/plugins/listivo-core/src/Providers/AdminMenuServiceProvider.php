<?php

namespace Tangibledesign\Listivo\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\Field;

class AdminMenuServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_menu', [$this, 'dashboard']);
    }

    public function dashboard(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $config = apply_filters('tdf/admin/dashboard', []);

        $this->menu($config);

        $this->items($config['slug'], $config['items']);

        $this->fieldItems();

        $this->currencyItems();

        $this->templateItems();

        $this->paymentPackageItem();

        $this->subscriptionItem();

        $this->notificationItem();
    }

    private function menu(array $config): void
    {
        add_menu_page(
            $config['name'],
            $config['name'],
            'manage_options',
            $config['slug'],
            static function () {
            },
            '',
            2
        );
    }

    private function items(string $parentSlug, array $items): void
    {
        foreach ($items as $item) {
            $this->item($parentSlug, $item);
        }
    }

    private function item(string $parentSlug, array $item): void
    {
        add_submenu_page(
            $parentSlug,
            $item['name'],
            $item['name'],
            'manage_options',
            tdf_app('slug') . '_' . $item['slug'],
            static function () use ($item) {
                require tdf_app('path') . 'views/dashboard/' . $item['slug'] . '.php';
            }
        );
    }

    private function fieldItems(): void
    {
        foreach (tdf_fields() as $field) {
            $this->fieldItem($field);
        }

        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('add_new_field'),
            tdf_admin_string('add_new_field'),
            'manage_options',
            tdf_app('prefix') . '-add-new-field',
            static function () {
                require tdf_app('path') . 'views/dashboard/fields/create.php';
            }
        );
    }

    private function fieldItem(Field $currentField): void
    {
        add_submenu_page(
            tdf_prefix() . '_custom_fields',
            $currentField->getName(),
            $currentField->getName(),
            'manage_options',
            tdf_app('prefix') . '-field-' . $currentField->getId(),
            static function () use ($currentField) {
                global $field;
                $field = $currentField;

                require tdf_app('path') . 'views/dashboard/fields/field.php';
            }
        );
    }

    private function currencyItems(): void
    {
        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('add_new_currency'),
            tdf_admin_string('add_new_currency'),
            'manage_options',
            tdf_app('prefix') . '-add-new-currency',
            static function () {
                require tdf_app('path') . 'views/dashboard/settings/currency/create.php';
            }
        );

        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('edit_currency'),
            tdf_admin_string('edit_currency'),
            'manage_options',
            tdf_app('prefix') . '-edit-currency',
            static function () {
                require tdf_app('path') . 'views/dashboard/settings/currency/edit.php';
            }
        );
    }

    private function templateItems(): void
    {
        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('add_new_template'),
            tdf_admin_string('add_new_template'),
            'manage_options',
            tdf_app('prefix') . '-add-new-template',
            static function () {
                require tdf_app('path') . 'views/dashboard/templates/create.php';
            }
        );
    }

    private function notificationItem(): void
    {
        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('add_new_notification'),
            tdf_admin_string('add_new_notification'),
            'manage_options',
            tdf_app('prefix') . '-add-new-notification',
            static function () {
                require tdf_app('path') . 'views/dashboard/notifications/create.php';
            }
        );

        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('edit_notification'),
            tdf_admin_string('edit_notification'),
            'manage_options',
            tdf_app('prefix') . '-edit-notification',
            static function () {
                require tdf_app('path') . 'views/dashboard/notifications/edit.php';
            }
        );
    }

    private function paymentPackageItem(): void
    {
        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('add_new_package'),
            tdf_admin_string('add_new_package'),
            'manage_options',
            tdf_app('prefix') . '-add-new-package',
            static function () {
                require tdf_app('path') . 'views/dashboard/packages/create.php';
            }
        );

        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('edit_package'),
            tdf_admin_string('edit_package'),
            'manage_options',
            tdf_app('prefix') . '-edit-package',
            static function () {
                require tdf_app('path') . 'views/dashboard/packages/edit.php';
            }
        );
    }

    private function subscriptionItem(): void
    {
        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('add_new_subscription'),
            tdf_admin_string('add_new_subscription'),
            'manage_options',
            tdf_app('prefix') . '-add-new-subscription',
            static function () {
                require tdf_app('path') . 'views/dashboard/subscriptions/create.php';
            }
        );

        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('edit_subscription'),
            tdf_admin_string('edit_subscription'),
            'manage_options',
            tdf_app('prefix') . '-edit-subscription',
            static function () {
                require tdf_app('path') . 'views/dashboard/subscriptions/edit.php';
            }
        );
    }
}