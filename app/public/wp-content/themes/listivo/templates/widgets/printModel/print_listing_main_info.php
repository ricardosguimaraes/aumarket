<?php
/* @var \Tangibledesign\Listivo\Widgets\PrintModel\PrintListingMainInfoWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}

$lstMainValue = $lstCurrentWidget->getMainValue();
$lstAddress = $lstModel->getAddress();
?>
<div class="listivo-print-listing-main-info">
    <h1 class="listivo-print-listing-main-info__name">
        <?php echo esc_html($lstModel->getName()); ?>
    </h1>

    <?php if (!empty($lstMainValue)) : ?>
        <div class="listivo-print-listing-main-info__value">
            <?php echo esc_html($lstMainValue); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($lstAddress)) : ?>
        <div class="listivo-print-listing-main-info__address">
            <?php echo esc_html($lstAddress); ?>
        </div>
    <?php endif; ?>
</div>
