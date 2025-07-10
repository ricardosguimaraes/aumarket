<?php

namespace Tangibledesign\Framework\Providers\WooCommerce;

use Exception;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;

class PurchasePaymentPackageServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('wp_ajax_' . tdf_prefix() . '/paymentPackage/purchase', [$this, 'purchase']);
    }

    public function purchase(): void
    {
        WC()->cart->empty_cart();

        $paymentPackage = $this->fetchPaymentPackage();
        if (!$paymentPackage) {
            wp_redirect(site_url());
            exit;
        }

        try {
            WC()->cart->add_to_cart($paymentPackage->getProductId());

            wp_safe_redirect(wc_get_checkout_url());
            exit;
        } catch (Exception $e) {
            wp_redirect(site_url());
            exit;
        }
    }

    private function fetchPaymentPackage(): ?BasePaymentPackage
    {
        $paymentPackageId = (int)($_GET['id'] ?? 0);
        if (empty($paymentPackageId)) {
            return null;
        }

        $paymentPackage = tdf_payment_package_factory()->create($paymentPackageId);
        if (!$paymentPackage instanceof BasePaymentPackage) {
            return null;
        }

        return $paymentPackage;
    }
}