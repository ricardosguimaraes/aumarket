<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

defined('ABSPATH') || exit;

if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>
    <div id="payment" class="woocommerce-checkout-payment listivo-panel-payments-form">
        <?php do_action('listivo/panel/checkout/payments'); ?>

        <?php if (WC()->cart->needs_payment()) : ?>
            <ul class="wc_payment_methods payment_methods methods">
                <?php
                if (!empty($available_gateways)) {
                    foreach ($available_gateways as $gateway) {
                        wc_get_template('checkout/payment-method.php', ['gateway' => $gateway]);
                    }
                }
                ?>
            </ul>
        <?php endif; ?>

        <div class="form-row place-order">
            <?php wc_get_template('checkout/terms.php'); ?>

            <?php do_action('woocommerce_review_order_before_submit'); ?>

            <?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="listivo-simple-button listivo-simple-button--background-primary-1" id="place_order" data-value="' . esc_attr('Place order') . '">
                        ' . esc_attr(tdf_string('place_order')) . '
                </button>'); ?>

            <?php do_action('woocommerce_review_order_after_submit'); ?>

            <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
        </div>
    </div>
<?php
if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}
