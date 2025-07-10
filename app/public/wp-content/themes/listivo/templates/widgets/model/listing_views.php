<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingViewsWidget;

/* @var ModelViewsWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}
?>
<div class="listivo-listing-meta">
    <span class="listivo-listing-meta__label"><?php echo esc_html(tdf_string('views_colon')); ?></span>

    <span class="listivo-listing-meta__value"><?php echo esc_html($lstModel->getViews()); ?></span>
</div>