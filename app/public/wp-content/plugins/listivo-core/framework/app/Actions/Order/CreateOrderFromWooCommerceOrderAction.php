<?php

namespace Tangibledesign\Framework\Actions\Order;

use DateTime;
use WC_Abstract_Order;
use WC_Order;
use WC_Order_Item_Product;
use WC_Product;

class CreateOrderFromWooCommerceOrderAction
{

    public function execute(WC_Abstract_Order $order): int
    {
        $args = [
            'post_type' => tdf_prefix().'_order',
            'post_title' => $order->get_id(),
            'post_status' => 'publish',
            'post_author' => $order->get_user_id(),
            'meta_input' => [
                'type' => 'woocommerce',
                'wc_order_id' => $order->get_id(),
                'status' => $order->get_status(),
                'price' => $order->get_formatted_order_total(),
                'payment_package_id' => $this->getPaymentPackageKey($order),
            ],
        ];

        if ($order instanceof WC_Order) {
            $args['meta_input']['payment_method'] = $this->getOrderPaymentMethod($order);

            if ($order->get_date_created() instanceof DateTime) {
                $args['meta_input']['created_at'] = $order->get_date_created()->getTimestamp();
            }

            if ($order->get_date_modified() instanceof DateTime) {
                $args['meta_input']['updated_at'] = $order->get_date_modified()->getTimestamp();
            }
        }

        $orderId = wp_insert_post($args);
        if (is_wp_error($orderId)) {
            return 0;
        }

        return $orderId;
    }

    private function getOrderPaymentMethod(WC_Order $order): string
    {
        $paymentMethod = $order->get_payment_method();
        if ($paymentMethod === 'bacs') {
            return tdf_string('bacs');
        }

        if ($paymentMethod === 'cod') {
            return tdf_string('cod');
        }

        if ($paymentMethod === 'cheque') {
            return tdf_string('cheque');
        }

        return $order->get_payment_method_title();
    }

    private function getPaymentPackageKey(WC_Abstract_Order $order): string
    {
        $items = $order->get_items();
        if (empty($items)) {
            return 0;
        }

        $item = reset($items);
        if (!$item instanceof WC_Order_Item_Product) {
            return 0;
        }

        $product = $item->get_product();
        if (!$product instanceof WC_Product) {
            return 0;
        }

        return get_post_meta($product->get_id(), tdf_prefix().'_payment_package', true);
    }

}