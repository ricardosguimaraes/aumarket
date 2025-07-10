<?php
/**
 * Checkout coupon form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-coupon.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

defined('ABSPATH') || exit;

if (!wc_coupons_enabled()) { // @codingStandardsIgnoreLine.
    return;
}
?>
<div class="listivo-panel-checkout-coupon-link woocommerce-form-coupon-toggle">
    <?php wc_print_notice(apply_filters('woocommerce_checkout_coupon_message', tdf_string('have_discount_code') . ' <a href="#" class="showcoupon">' . tdf_string('click_here_to_enter_code') . '</a>'), 'notice'); ?>
</div>

<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">
    <div class="listivo-panel-checkout-coupon">
        <?php do_action('listivo/panel/checkout/coupon'); ?>

        <div class="listivo-panel-checkout-coupon__form">
            <div class="listivo-panel-checkout-coupon__input">
                <div class="listivo-input-v2">
                    <input
                            type="text"
                            name="coupon_code"
                            class="input-text"
                            placeholder="<?php echo esc_attr(tdf_string('coupon_code')); ?>"
                            id="coupon_code"
                            value=""
                    />
                </div>
            </div>

            <button
                    type="submit"
                    class="listivo-panel-checkout-coupon__button button"
                    name="apply_coupon"
                    value="<?php esc_attr_e('Apply coupon', 'listivo'); ?>"
            >
                <?php echo esc_html(tdf_string('apply')); ?>
            </button>
        </div>
    </div>
</form>