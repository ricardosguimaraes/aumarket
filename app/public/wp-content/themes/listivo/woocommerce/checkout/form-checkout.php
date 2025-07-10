<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
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

if (!defined('ABSPATH')) {
    exit;
}

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    return;
}

?>
    <div class="listivo-panel-section listivo-panel-section--bg-5">
        <div class="listivo-container">
            <h1 class="listivo-panel-section__label">
                <?php echo esc_html(tdf_string('checkout')); ?>
            </h1>
        </div>
    </div>

    <div class="listivo-panel-checkout">

        <div class="listivo-panel-checkout__container">

            <?php do_action('woocommerce_before_checkout_form', $checkout); ?>

            <?php woocommerce_checkout_coupon_form(); ?>

            <script>
                jQuery(document).ready(function() {
                    jQuery('.woocommerce-notices-wrapper:not(.woocommerce-notices-wrapper--current)').remove()
                })
            </script>

            <form name="checkout" method="post" class="checkout woocommerce-checkout"
                  action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">

                <div class="woocommerce-notices-wrapper woocommerce-notices-wrapper--current"></div>

                <?php if ($checkout->get_checkout_fields()) : ?>

                    <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                    <div class="col2-set listivo-panel-checkout__section" id="customer_details">
                        <div class="col-1">
                            <?php do_action('woocommerce_checkout_billing'); ?>
                        </div>

                        <div class="col-2">
                            <?php do_action('woocommerce_checkout_shipping'); ?>
                        </div>
                    </div>

                    <?php do_action('woocommerce_checkout_after_customer_details'); ?>

                <?php endif; ?>

                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                <h3 id="order_review_heading">
                    <?php echo esc_html(tdf_string('your_order')); ?>
                </h3>

                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order">
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>

            </form>

        </div>

    </div>
<?php do_action('woocommerce_after_checkout_form', $checkout); ?>