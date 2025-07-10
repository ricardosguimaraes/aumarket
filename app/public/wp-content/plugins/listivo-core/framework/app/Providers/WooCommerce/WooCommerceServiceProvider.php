<?php

namespace Tangibledesign\Framework\Providers\WooCommerce;

use Exception;
use Tangibledesign\Framework\Actions\WooCommerce\InstallWooCommerceAction;
use Tangibledesign\Framework\Core\Notification;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Order\OrderStatus;
use Tangibledesign\Framework\Models\Payments\PaymentPackage;
use Tangibledesign\Framework\Models\Payments\UserPaymentPackageInterface;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\General\PanelWidget;
use WC_Install;
use WC_Order;
use WC_Order_Item_Product;

class WooCommerceServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_init', static function () {
            remove_image_size('woocommerce_thumbnail');
            remove_image_size('woocommerce_single');
            remove_image_size('woocommerce_gallery_thumbnail');
            remove_image_size('shop_catalog');
            remove_image_size('shop_single');
            remove_image_size('shop_thumbnail');

            if (get_option('woocommerce_feature_order_attribution_enabled') !== 'yes') {
                update_option('woocommerce_feature_order_attribution_enabled', 'no');
            }
        });

        add_filter('nonce_user_logged_out', static function ($uid = 0, $action = '') {
            if (in_array($action, [
                tdf_prefix() . '_login',
                tdf_prefix() . '_register',
                tdf_prefix() . '_reset_password',
                tdf_prefix() . '_create_model',
                tdf_prefix() . '_send_reset_password_link',
                tdf_prefix() . '_set_password',
                tdf_prefix() . '_create_message',
            ], true)) {
                return 0;
            }

            return $uid;
        }, 100, 2);

        add_action('admin_post_' . tdf_prefix() . '/woocommerce/install', [$this, 'install']);

        add_action('tdf/settings/saved', static function () {
            if (class_exists(WC_Install::class)) {
                WC_Install::create_pages();
            }
        });

        add_action('template_redirect', static function () {
            if (!function_exists('is_cart') || !is_cart()) {
                return;
            }

            wp_redirect(tdf_settings()->getPanelPageUrl());
            exit;
        });
    }

    public function install(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        InstallWooCommerceAction::install();

        wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_basic_setup&tab=monetization#'));
        exit;
    }

}