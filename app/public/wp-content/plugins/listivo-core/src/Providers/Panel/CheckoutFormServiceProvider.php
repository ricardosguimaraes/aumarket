<?php

namespace Tangibledesign\Listivo\Providers\Panel;

use Tangibledesign\Framework\Core\ServiceProvider;

class CheckoutFormServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');

        add_action('init', function () {
            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form');
        }, 99999);

        add_filter('woocommerce_cart_totals_coupon_html', [$this, 'couponInfoHtml'], 10, 3);

        add_filter('wc_stripe_elements_styling', static function () {
            return [
                'base' => [
                    'iconColor' => '#666EE8',
                    'color' => tdf_app('lcolor2'),
                    'fontSize' => '16px',
                    'lineHeight' => '60px',
                    '::placeholder' => [
                        'color' => tdf_app('lcolor2'),
                    ],
                ],
            ];
        });
    }

    public function couponInfoHtml($couponHtml, $coupon, $discountAmountHtml): string
    {
        return $discountAmountHtml
            . ' <a href="' . esc_url(add_query_arg('remove_coupon', rawurlencode($coupon->get_code()), defined('WOOCOMMERCE_CHECKOUT') ? wc_get_checkout_url() : wc_get_cart_url())) . '" class="woocommerce-remove-coupon" data-coupon="' . esc_attr($coupon->get_code()) . '"></a>';
    }

}