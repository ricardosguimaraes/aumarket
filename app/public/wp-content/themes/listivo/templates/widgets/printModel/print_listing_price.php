<?php
/* @var \Tangibledesign\Listivo\Widgets\PrintModel\PrintListingPriceWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}

$lstMainValue = $lstCurrentWidget->getMainValue();
if (empty($lstMainValue)) {
    return;
}
?>
<div class="listivo-print-price-wrapper">
    <div class="listivo-print-price">
        <?php echo esc_html($lstMainValue); ?>
    </div>
</div>
