<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingTextFieldWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstValue = $lstCurrentWidget->getValue();
?>
<div class="listivo-listing__text-field">
    <?php echo esc_html($lstValue); ?>
</div>
