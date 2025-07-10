<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingNumberFieldWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstValue = $lstCurrentWidget->getValue();
if (empty($lstValue)) {
    return;
}
?>
<div class="listivo-listing__number-field">
    <?php echo esc_html($lstValue); ?>
</div>
