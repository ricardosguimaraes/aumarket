<?php

$available_gateways = isset($args['available_gateways']) ? $args['available_gateways'] : [];

if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_before_payment');
}
?>
    <div id="payment" class="woocommerce-checkout-payment">
        <h3 class="listivo-panel-checkout__label listivo-panel-checkout__label--margin-top">
            <?php echo esc_html(tdf_string('payments')); ?>
        </h3>

        <div class="listivo-panel-payments-form">
            <?php do_action('listivo/panel/checkout/payments'); ?>

            <?php if (WC()->cart->needs_payment()) : ?>
                <ul class="listivo-panel-payments-form__list wc_payment_methods payment_methods methods">
                    <?php
                    if (!empty($available_gateways)) {
                        foreach ($available_gateways as $gateway) {
                            wc_get_template('checkout/payment-method.php', array('gateway' => $gateway));
                        }
                    } else {
                        echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters('woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__('Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'listivo') : esc_html__('Please fill in your details above to see available payment methods.', 'listivo')) . '</li>'; // @codingStandardsIgnoreLine
                    }
                    ?>
                </ul>
            <?php endif; ?>
            <div class="form-row place-order">
                <noscript>
                    <?php
                    /* translators: $1 and $2 opening and closing emphasis tags respectively */
                    printf(esc_html__('Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'listivo'), '<em>', '</em>');
                    ?>
                    <br/>
                    <button type="submit" class="button alt" name="woocommerce_checkout_update_totals"
                            value="<?php esc_attr_e('Update totals', 'listivo'); ?>"><?php esc_html_e('Update totals', 'listivo'); ?></button>
                </noscript>

                <?php wc_get_template('checkout/terms.php'); ?>

                <?php do_action('woocommerce_review_order_before_submit'); ?>

                <div class="listivo-panel-payments-form__button">
                    <?php echo apply_filters('woocommerce_order_button_html', '<button type="submit" class="listivo-button listivo-button--primary-1 listivo-button-primary-1-colors-with-stroke-selector" data-value="' . esc_attr(tdf_string('place_order')) . '">
                    <span>
                        ' . esc_html(tdf_string('place_order')) . '

                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="10" viewBox="0 0 14 10"
                                 fill="none">
                                <rect x="12.2656" y="0.646447" width="1.53602" height="11.5509" rx="0.768011"
                                      transform="rotate(45 12.2656 0.646447)" fill="#FDFDFE" stroke="#FDFDFE"
                                      stroke-width="0.5"/>
                                <path d="M5.66258 8.41353L2.27076 4.98708C1.97447 4.68776 1.49125 4.68653 1.19345 4.98434C0.891119 5.28667 0.897654 5.77882 1.20791 6.07301L4.70642 9.39045C4.94829 9.61981 5.32032 9.64127 5.58696 9.44126C5.9186 9.19249 5.95423 8.70816 5.66258 8.41353Z"
                                      fill="#FDFDFE" stroke="#FDFDFE" stroke-width="0.5"/>
                            </svg>
                    </span>
                </button>'); ?>
                </div>

                <?php do_action('woocommerce_review_order_after_submit'); ?>

                <?php wp_nonce_field('woocommerce-process_checkout', 'woocommerce-process-checkout-nonce'); ?>
            </div>
        </div>
    </div>
<?php
if (!wp_doing_ajax()) {
    do_action('woocommerce_review_order_after_payment');
}