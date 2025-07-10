<?php

namespace Tangibledesign\Framework\Providers\Orders;

use Stripe\Invoice;
use Tangibledesign\Framework\Actions\Order\CountOrdersByStatusAction;
use Tangibledesign\Framework\Actions\Order\CreateOrderFromStripeInvoiceAction;
use Tangibledesign\Framework\Actions\Order\CreateOrderFromWooCommerceOrderAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use WC_Abstract_Order;

class OrdersServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['orders_count'] = static function () {
            return (new CountOrdersByStatusAction())->execute();
        };

        $this->container['orders_completed_count'] = static function () {
            return (new CountOrdersByStatusAction())->execute('completed');
        };

        $this->container['orders_processing_count'] = static function () {
            return (new CountOrdersByStatusAction())->execute('processing');
        };

        $this->container['orders_pending_count'] = static function () {
            return (new CountOrdersByStatusAction())->execute('pending');
        };

        $this->container['orders_on_hold_count'] = static function () {
            return (new CountOrdersByStatusAction())->execute('on-hold');
        };

        $this->container['orders_cancelled_count'] = static function () {
            return (new CountOrdersByStatusAction())->execute('cancelled');
        };

        $this->container['orders_refunded_count'] = static function () {
            return (new CountOrdersByStatusAction())->execute('refunded');
        };

        $this->container['orders_failed_count'] = static function () {
            return (new CountOrdersByStatusAction())->execute('failed');
        };
    }

    public function afterInitiation(): void
    {
        add_action('woocommerce_checkout_order_processed', [$this, 'wooCommerceOnNewOrder'], 10, 1);

        add_action('woocommerce_order_status_changed', [$this, 'wooCommerceOnOrderStatusChanged'], 10, 3);

        add_action('woocommerce_delete_order', [$this, 'wooCommerceOnOrderDeleted'], 10, 1);

        add_action('tdf/stripe/invoice/paid', [$this, 'createOrderFromStripeInvoice']);
    }

    public function createOrderFromStripeInvoice(Invoice $invoice): void
    {
        (new CreateOrderFromStripeInvoiceAction())->execute($invoice);
    }

    public function wooCommerceOnOrderDeleted($wcOrderId): void
    {
        $wcOrder = wc_get_order($wcOrderId);
        if (!$wcOrder instanceof WC_Abstract_Order) {
            return;
        }

        $orderId = (int)get_post_meta($wcOrderId, tdf_prefix().'_order', true);
        if (empty($orderId)) {
            return;
        }

        wp_delete_post($orderId, true);
    }

    public function wooCommerceOnNewOrder($wcOrderId): void
    {
        $wcOrder = wc_get_order($wcOrderId);
        if (!$wcOrder instanceof WC_Abstract_Order) {
            return;
        }

        $orderId = (new CreateOrderFromWooCommerceOrderAction())->execute($wcOrder);
        if (empty($orderId)) {
            return;
        }

        update_post_meta($wcOrderId, tdf_prefix().'_order', $orderId);
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function wooCommerceOnOrderStatusChanged($wcOrderId, $oldStatus, $newStatus): void
    {
        $wcOrder = wc_get_order($wcOrderId);
        if (!$wcOrder instanceof WC_Abstract_Order) {
            return;
        }

        $orderId = (int)get_post_meta($wcOrderId, tdf_prefix().'_order', true);
        if (empty($orderId)) {
            (new CreateOrderFromWooCommerceOrderAction())->execute($wcOrder);
            return;
        }

        update_post_meta($orderId, 'status', $newStatus);
    }

}