<?php

use Tangibledesign\Framework\Models\Payments\Order;

/* @var Order $lstCurrentOrder */
global $lstCurrentOrder;
?>
<div class="listivo-panel-orders__row listivo-panel-orders__row--my-orders">
    <div class="listivo-panel-orders__main-col">
        <div class="listivo-panel-order">
            <h3 class="listivo-panel-order__heading">
                <?php
                $orderLabel = $lstCurrentOrder->getLabel();
                if (!empty($orderLabel)) : ?>
                    <span><?php echo esc_html($orderLabel); ?></span>
                <?php endif; ?>

                <span class="listivo-panel-order__order">
                    (<?php echo esc_html(tdf_string('order')); ?>
                    #<?php echo esc_html($lstCurrentOrder->getOrderId()); ?>)
                </span>
            </h3>

            <div class="listivo-panel-order__info">
                <div class="listivo-panel-order__attributes">
                    <?php if ($lstCurrentOrder->getCreatedAt() !== null): ?>
                        <div class="listivo-panel-order__meta">
                            <span><?php echo esc_html(tdf_string('created')); ?>:</span>

                            <?php echo esc_html(date_i18n(get_option('date_format'), $lstCurrentOrder->getCreatedAt()->getTimestamp())); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (
                        $lstCurrentOrder->getUpdatedAt() !== null
                        && $lstCurrentOrder->getCreatedAt() !== null
                        && $lstCurrentOrder->getCreatedAt()->format(get_option('date_format')) !== $lstCurrentOrder->getUpdatedAt()->format(get_option('date_format'))
                    ) : ?>
                        <div class="listivo-panel-order__meta">
                            <span><?php echo esc_html(tdf_string('modified')); ?>:</span>

                            <?php echo esc_html(date_i18n(get_option('date_format'), $lstCurrentOrder->getCreatedAt()->getTimestamp())); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="listivo-panel-order__status">
                    <div class="listivo-panel-order-status listivo-panel-order-status--<?php echo esc_attr($lstCurrentOrder->getStatus()); ?>">
                        <?php echo esc_html($lstCurrentOrder->getFormattedStatus()); ?>
                    </div>
                </div>

                <div class="listivo-panel-order__data">
                    <div class="listivo-panel-order__price">
                        <?php echo wp_kses_post($lstCurrentOrder->getPrice()); ?>

                        <?php if (!empty($lstCurrentOrder->getPaymentMethod())) : ?>
                            <span class="listivo-panel-order__payment-method">
                                <?php echo esc_html(tdf_string('via') . ' ' . $lstCurrentOrder->getPaymentMethod()); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($lstCurrentOrder->getInvoiceUrl())) : ?>
                    <div class="listivo-panel-order__attributes">
                        <div class="listivo-panel-order__meta">
                            <span><?php echo esc_html(tdf_string('invoice')); ?>:</span>

                            <a href="<?php echo esc_url($lstCurrentOrder->getInvoiceUrl()); ?>" target="_blank">
                                <?php echo esc_html(tdf_string('download')); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="listivo-panel-orders__col listivo-panel-orders__col--status">
        <div class="listivo-panel-order-status listivo-panel-order-status--<?php echo esc_attr($lstCurrentOrder->getStatus()); ?>">
            <?php echo esc_html($lstCurrentOrder->getFormattedStatus()); ?>
        </div>
    </div>
</div>