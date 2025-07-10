<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingPriceWidget;

/* @var ListingPriceWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}

$lstMainValue = $lstCurrentWidget->getMainValue();
$lstTextWhenEmpty = $lstCurrentWidget->getTextWhenEmpty();
if (empty($lstMainValue) && empty($lstTextWhenEmpty)) {
    return;
}
?>
<div class="listivo-listing-price">
    <?php if (!empty($lstMainValue)) : ?>
        <?php echo esc_html($lstMainValue); ?>
    <?php else : ?>
        <?php echo esc_html($lstTextWhenEmpty); ?>
    <?php endif; ?>
</div>
