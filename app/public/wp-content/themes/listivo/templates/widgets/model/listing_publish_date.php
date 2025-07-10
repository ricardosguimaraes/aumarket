<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingPublishDateWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}
?>
<div class="listivo-listing__date">
    <span class="listivo-listing__date-label"><?php echo esc_html(tdf_string('published_colon')); ?></span>
    <span class="listivo-listing__date-value"><?php echo esc_html($lstModel->getPublishDate()); ?></span>
</div>
