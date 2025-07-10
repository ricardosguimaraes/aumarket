<?php

namespace Tangibledesign\Framework\Providers\WooCommerce;

use Exception;
use Tangibledesign\Framework\Actions\PaymentPackage\ApplyPackageToModelInProgressAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\Payments\OrderStatus;
use Tangibledesign\Framework\Models\Payments\PaymentPackage;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\General\PanelWidget;
use WC_Order;
use WC_Order_Item_Product;

class WooCommercePaymentsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('wp_ajax_' . tdf_prefix() . '/woocommerce/checkout', [$this, 'checkout']);

        add_action('woocommerce_payment_complete', [$this, 'paymentComplete']);

        add_action('woocommerce_order_status_changed', [$this, 'orderStatusChanged'], 10, 3);
    }

    /** @noinspection PhpUnusedParameterInspection */
    public function orderStatusChanged(int $orderId, string $oldStatus, string $newStatus): void
    {
        if (!$orderId || $newStatus !== 'completed') {
            return;
        }

        $order = wc_get_order($orderId);
        if (!$order || (!in_array($order->get_payment_method(),
                $this->getApplicablePaymentMethodsForOrderStatus()))) {
            return;
        }

        $this->applyPackageFromOrder($order);
    }

    private function getApplicablePaymentMethodsForOrderStatus(): array
    {
        return [
            'bacs',
            'cod',
            'cheque',
            'multicaixa_proxypay',
            'netopiapayments',
            'softtech_bkash',
            'SoftTechIT_Bkash',
            'coinbase-commerce-for-woocommerce',
            'gopay-inline',
            'woo-gopay-imline',
            'WC_MPESA_Gateway',
            'mpesa',
            'WC_PagSeguro_Gateway',
            'pagseguro',
            'liqpay',
            'WC_Gateway_kmnd_Liqpay',
            'zitopay',
            'WC_Gateway_zitopay',
            'pesapal',
            'WC_TheBunchKE_PesaPal_Pay_Gateway',
            'ecommerceconnect',
            'WAL_Gateway_Wallet',
            'wallet-for-woocommerce',
            'wal_wallet',
        ];
    }

    public function paymentComplete(int $orderId): void
    {
        if (!$orderId) {
            return;
        }

        $order = wc_get_order($orderId);
        if (!$order || in_array($order->get_payment_method(), $this->getApplicablePaymentMethodsForOrderStatus())) {
            return;
        }

        $this->applyPackageFromOrder($order);

        if ($order->get_status() !== OrderStatus::COMPLETED) {
            $order->set_status(OrderStatus::COMPLETED);

            $order->save();
        }
    }

    public function checkout(): void
    {
        if (!isset($_POST['packageKey'], $_POST['nonce']) || !wp_verify_nonce($_POST['nonce'],
                tdf_prefix() . '_buy_package')) {
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die();
        }

        $packageKey = $_POST['packageKey'];
        if ($packageKey === 'free' && tdf_settings()->isFreeListingEnabled()) {
            $this->applyFreeListing();

            /** @noinspection JsonEncodingApiUsageInspection */
            echo json_encode(['redirect' => PanelWidget::getUrl(PanelWidget::ACTION_LIST)]);
            exit;
        }

        $package = tdf_payment_packages()->find(static function ($paymentPackage) use ($packageKey) {
            /* @var PaymentPackage $paymentPackage */
            return $paymentPackage->getKey() === $packageKey;
        });

        if (!$package || !$package->isProductAssigned()) {
            http_response_code(500);
            exit;
        }

        WC()->cart->empty_cart();

        try {
            WC()->cart->add_to_cart($package->getProductId());
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }

        /** @noinspection JsonEncodingApiUsageInspection */
        echo json_encode(['redirect' => wc_get_checkout_url()]);
        exit;
    }

    private function applyPackageFromOrder(WC_Order $order): void
    {
        $user = tdf_user_factory()->create($order->get_user_id());
        if (!$user) {
            return;
        }

        foreach ($order->get_items() as $item) {
            $itemProduct = new WC_Order_Item_Product($item->get_id());

            $paymentPackage = BasePaymentPackage::getByAssignedProduct($itemProduct->get_product_id());
            if (!$paymentPackage) {
                return;
            }

            $package = $user->addPaymentPackage($paymentPackage);
            if (!$package) {
                return;
            }

            if (!$user->hasModelInProgress()) {
                return;
            }

            (new ApplyPackageToModelInProgressAction())->execute($user->getModelInProgress(), $package);

            $user->removeModelInProgress();
        }
    }

    private function applyFreeListing(): void
    {
        $user = tdf_current_user();
        if (!$user instanceof User) {
            return;
        }

        $user->addPaymentPackage(tdf_app('free_package'));

        if (!$user->hasModelInProgress()) {
            return;
        }

        (new ApplyPackageToModelInProgressAction())->execute($user->getModelInProgress(), tdf_app('free_package'));

        $user->removeModelInProgress();
    }

}