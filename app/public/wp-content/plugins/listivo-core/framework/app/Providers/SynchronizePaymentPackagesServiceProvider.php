<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\Post\PostStatus;

class SynchronizePaymentPackagesServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action(tdf_prefix().'/paymentPackages/synchronize', [$this, 'synchronize']);

//        add_action('admin_init', [$this, 'synchronize']);
    }

    public function synchronize(): void
    {
        if (!function_exists('wc_get_product') || !$this->isWooCommerceActive()) {
            return;
        }

        $ids = array_merge(
            tdf_settings()->getPaymentPackageIds(),
            tdf_settings()->getBumpsPaymentPackageIds()
        );

        if (empty($ids)) {
            return;
        }

        tdf_query_payment_packages()->in($ids)->get()->each(function ($paymentPackage) {
            /* @var BasePaymentPackage $paymentPackage */
            if (!$paymentPackage->isProductAssigned()) {
                $this->createProduct($paymentPackage);
            } else {
                $this->updateProduct($paymentPackage);
            }
        });
    }

    /**
     * @param  BasePaymentPackage  $paymentPackage
     */
    private function createProduct(BasePaymentPackage $paymentPackage): void
    {
        $productId = wp_insert_post([
            'post_title' => $paymentPackage->getName(),
            'post_content' => $paymentPackage->getDescription(),
            'post_type' => 'product',
            'post_status' => PostStatus::PUBLISH
        ]);

        update_post_meta($productId, tdf_prefix().'_payment_package', $paymentPackage->getKey());

        wp_set_object_terms($productId, 'simple', 'product_type');

        update_post_meta($productId, '_virtual', 'yes');
        update_post_meta($productId, '_regular_price', $paymentPackage->getPrice());
        update_post_meta($productId, '_price', $paymentPackage->getPrice());

        $paymentPackage->assignProduct($productId);
    }

    /**
     * @param  BasePaymentPackage  $paymentPackage
     */
    private function updateProduct(BasePaymentPackage $paymentPackage): void
    {
        $productId = $paymentPackage->getProductId();

        wp_update_post([
            'ID' => $productId,
            'post_title' => $paymentPackage->getName(),
            'post_content' => $paymentPackage->getDescription(),
        ]);

        update_post_meta($productId, '_regular_price', $paymentPackage->getPrice());
        update_post_meta($productId, '_price', $paymentPackage->getPrice());
    }

    /**
     * @return bool
     */
    public function isWooCommerceActive(): bool
    {
        return in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')),
            true);
    }

}