<?php

use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingNameWidget;

/* @var PrintListingNameWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}
?>
<h1 class="listivo-print-name">
    <?php echo esc_html($lstModel->getName()); ?>
</h1>