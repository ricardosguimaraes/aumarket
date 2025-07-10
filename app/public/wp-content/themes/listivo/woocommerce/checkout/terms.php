<?php
/**
 * Checkout terms and conditions area.
 *
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

defined('ABSPATH') || exit;

if (apply_filters('woocommerce_checkout_show_terms', true) && function_exists('wc_terms_and_conditions_checkbox_enabled')) {
    do_action('woocommerce_checkout_before_terms_and_conditions');
    ?>
    <div class="woocommerce-terms-and-conditions-wrapper">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M14.3672 28.4339H15.6328C22.7391 28.4339 28.5 22.4194 28.5 15C28.5 7.58064 22.7391 1.56606 15.6328 1.56606L14.3672 1.56606C7.26086 1.56606 1.5 7.58064 1.5 15C1.5 22.4194 7.26086 28.4339 14.3672 28.4339ZM15.6328 30C23.5676 30 30 23.2843 30 15C30 6.71573 23.5676 1.90735e-06 15.6328 1.90735e-06L14.3672 1.90735e-06C6.43244 1.90735e-06 0 6.71573 0 15C0 23.2843 6.43244 30 14.3672 30L15.6328 30Z"
                  fill="#F09965"/>
            <path d="M15.5 7.75C15.5 8.16421 15.1784 8.5 14.7816 8.5H14.7184C14.3216 8.5 14 8.16421 14 7.75C14 7.33579 14.3216 7 14.7184 7H14.7816C15.1784 7 15.5 7.33579 15.5 7.75Z"
                  fill="#F09965"/>
            <path d="M15.5 22.217C15.5 22.6494 15.1642 23 14.75 23C14.3358 23 14 22.6494 14 22.217L14 11.283C14 10.8506 14.3358 10.5 14.75 10.5C15.1642 10.5 15.5 10.8506 15.5 11.283L15.5 22.217Z"
                  fill="#F09965"/>
        </svg>

        <?php do_action('woocommerce_checkout_terms_and_conditions'); ?>

        <?php if (wc_terms_and_conditions_checkbox_enabled()) : ?>
            <div class="form-row validate-required">
                <label class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
                    <input type="checkbox"
                           class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox"
                           name="terms" <?php checked(apply_filters('woocommerce_terms_is_checked_default', isset($_POST['terms'])), true); // WPCS: input var ok, csrf ok. ?>
                           id="terms"/>

                    <span class="woocommerce-terms-and-conditions-checkbox-text"><?php wc_terms_and_conditions_checkbox_text(); ?></span>&nbsp;<abbr
                            class="required" title="<?php esc_attr_e('required', 'listivo'); ?>">*</abbr>
                </label>

                <input type="hidden" name="terms-field" value="1"/>
            </div>
        <?php endif; ?>
    </div>
    <?php

    do_action('woocommerce_checkout_after_terms_and_conditions');
}