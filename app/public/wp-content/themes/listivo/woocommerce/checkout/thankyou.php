<?php
/**
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */
use Tangibledesign\Framework\Widgets\General\PanelWidget;

defined('ABSPATH') || exit;
?>
<div class="listivo-panel-head listivo-panel-head--v2">
    <div class="listivo-container">
        <div class="listivo-panel-head__label listivo-panel-head__label--center">
            <h1>
                <?php
                /* @var WC_Order $order */
                if ($order) : ?>
                    <?php echo esc_attr(tdf_string('thank_you_for_your_order')); ?>

                    <span>#<?php echo esc_html($order->get_id()); ?></span>
                <?php else : ?>
                    <?php echo esc_html(tdf_string('thank_you_order')); ?>
                <?php endif; ?>
            </h1>
        </div>
    </div>
</div>

<div class="listivo-panel-section">
    <div class="listivo-thank-you-container">
        <div class="listivo-container">
            <?php $product = tdf_woo_product_factory()->create($order); ?>

            <div class="listivo-panel-thank-you-package">
                <div class="listivo-panel-thank-you-package__top">
                    <?php if ($product) : ?>
                        <?php echo esc_html($product->get_name()); ?>
                    <?php endif; ?>
                </div>

                <div class="listivo-panel-thank-you-package__content">
                    <?php echo wp_kses_post($order->get_formatted_order_total()); ?>
                </div>
            </div>

            <?php
            /* @var WC_Order $order */
            if ($order) :
                $product = tdf_woo_product_factory()->create($order);

                do_action('woocommerce_before_thankyou', $order->get_id());
                ?>
                <div class="listivo-car-form__section">
                    <?php if ($order->has_status('failed')) : ?>
                        <h3 class="listivo-thank-you__title">
                            <?php echo esc_html(tdf_string('unfortunately_your_order_cannot')); ?>
                        </h3>

                        <div class="listivo-thank-you__button">
                            <a
                                    class="listivo-primary-button"
                                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_LIST)); ?>"
                            >
                                <span class="listivo-primary-button__text">
                                    <?php echo esc_html(tdf_string('back_to_panel')); ?>
                                </span>
                            </a>
                        </div>
                    <?php else : ?>
                        <?php do_action('woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id()); ?>

                        <?php do_action('woocommerce_thankyou', $order->get_id()); ?>

                        <div class="listivo-thank-you-container__button">
                            <a
                                    class="listivo-button listivo-button--height-60 listivo-button--primary-1 listivo-button-primary-1-colors-with-stroke-selector"
                                    href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_LIST)); ?>"
                            >
                                <span>
                                    <?php echo esc_html(tdf_string('back_to_panel')); ?>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="10"
                                         viewBox="0 0 14 10" fill="none">
                                        <rect x="12.2676" y="0.646447" width="1.53602" height="11.5509"
                                              rx="0.768011" transform="rotate(45 12.2676 0.646447)" fill="#FDFDFE"
                                              stroke="#FDFDFE" stroke-width="0.5"/>
                                        <path d="M1.19345 4.98437C0.891119 5.2867 0.897654 5.77885 1.20791 6.07304L4.70642 9.39049C4.94829 9.61984 5.32032 9.6413 5.58696 9.44129C5.91859 9.19252 5.95423 8.70819 5.66258 8.41356L2.27076 4.98711C1.97447 4.68779 1.49125 4.68657 1.19345 4.98437Z"
                                              fill="#FDFDFE" stroke="#FDFDFE" stroke-width="0.5"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>