<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingIdWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}
?>
<div class="listivo-listing-meta">
    <?php echo esc_html($lstModel->getId()); ?>
</div>
