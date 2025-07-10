<?php

namespace Tangibledesign\Framework\Providers\WooCommerce;

use Exception;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\BumpPaymentPackage;

class PurchaseBumpPackageServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('wp_ajax_' . tdf_prefix() . '/paymentPackage/bump/purchase', [$this, 'purchase']);
    }

    public function purchase(): void
    {
        $modelId = (int)($_GET['id'] ?? 0);
        if (!empty($modelId)) {
            /** @noinspection NullPointerExceptionInspection */
            tdf_current_user()->setModelInProgress($modelId);
        }

        WC()->cart->empty_cart();

        $paymentPackage = tdf_bumps_payment_packages()->first();
        if (!$paymentPackage instanceof BumpPaymentPackage) {
            return;
        }

        try {
            WC()->cart->add_to_cart($paymentPackage->getProductId());
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }

        wp_safe_redirect(wc_get_checkout_url());
        exit;
    }
}