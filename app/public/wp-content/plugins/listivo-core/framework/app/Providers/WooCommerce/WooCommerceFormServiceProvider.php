<?php

namespace Tangibledesign\Framework\Providers\WooCommerce;

use Tangibledesign\Framework\Core\ServiceProvider;

class WooCommerceFormServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_filter('woocommerce_checkout_fields', [$this, 'checkoutFields']);

        add_filter('woocommerce_order_button_text', static function () {
            return tdf_string('place_order');
        });

        add_filter('woocommerce_order_button_html', function ($buttonHtml) {
            return str_replace('Place order', tdf_string('place_order'), $buttonHtml);
        });

        add_filter('woocommerce_create_pages', function ($body) {
            if (!isset($body['checkout'])) {
                return $body;
            }

            $body['checkout']['content'] = '<!-- wp:shortcode -->[' . apply_filters('woocommerce_checkout_shortcode_tag', 'woocommerce_checkout') . ']<!-- /wp:shortcode -->';

            return $body;
        });
    }

    public function checkoutFields(array $fields): array
    {
        unset($fields['order']['order_comments']);

        return $fields;
    }
}