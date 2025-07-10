<?php

use Tangibledesign\Listivo\Widgets\General\ListingNameWidget;

/* @var ListingNameWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}
?>
<<?php echo esc_html($lstCurrentWidget->getTag()); ?> class="listivo-listing-name">
<?php echo esc_html($lstModel->getName()); ?>
</<?php echo esc_html($lstCurrentWidget->getTag()); ?>>