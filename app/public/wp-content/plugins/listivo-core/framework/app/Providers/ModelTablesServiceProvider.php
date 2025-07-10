<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class ModelTablesServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class ModelTablesServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_init', [$this, 'createTables']);

        add_action('admin_post_' . tdf_prefix() . '/model/clearData', [$this, 'clearData']);
    }

    public function clearData(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        global $wpdb;

        $tables = [
            $wpdb->prefix . tdf_prefix() . '_views',
            $wpdb->prefix . tdf_prefix() . '_recently_viewed',
        ];

        foreach ($tables as $table) {
            $wpdb->query("TRUNCATE TABLE $table");
        }

        wp_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_advanced'));
        exit;
    }

    public function createTables(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $this->createRecentlyViewedTable();

        $this->createViewsTable();
    }

    private function createViewsTable(): void
    {
        global $wpdb;
        $charsetCollate = $wpdb->get_charset_collate();

        $tableName = $wpdb->prefix . tdf_prefix() . '_views';

        $statement = "CREATE TABLE `{$tableName}` (
            id bigint(20) NOT NULL auto_increment,
            model_id bigint(20) UNSIGNED NOT NULL,
            count bigint(20) UNSIGNED NOT NULL,
            date date NOT NULL,
            PRIMARY KEY  (id)
        ) $charsetCollate;";

        maybe_create_table($tableName, $statement);
    }

    private function createRecentlyViewedTable(): void
    {
        global $wpdb;
        $charsetCollate = $wpdb->get_charset_collate();

        $tableName = $wpdb->prefix . tdf_prefix() . '_recently_viewed';

        $statement = "CREATE TABLE `{$tableName}` (
            id bigint(20) NOT NULL auto_increment,
            model_id bigint(20) UNSIGNED NOT NULL,
            PRIMARY KEY  (id)
        ) $charsetCollate;";

        maybe_create_table($tableName, $statement);
    }

}