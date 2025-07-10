<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingInfoWidget;

/* @var ListingInfoWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}
?>
<div class="listivo-listing-info">
    <div class="listivo-listing-info__data">
        <?php echo esc_html(tdf_string('id_colon') . ' ' . $lstModel->getId()); ?>
    </div>

    <div class="listivo-listing-info__data">
        <?php echo esc_html(tdf_string('published_colon') . ' ' . $lstModel->getPublishDate()); ?>
    </div>

    <div class="listivo-listing-info__data">
        <?php echo esc_html(tdf_string('views_colon') . ' ' . $lstModel->getViews()); ?>
    </div>
</div>
