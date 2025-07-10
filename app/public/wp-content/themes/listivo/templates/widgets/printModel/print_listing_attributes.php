<?php
/* @var \Tangibledesign\Listivo\Widgets\PrintModel\PrintListingAttributesWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstAttributes = $lstCurrentWidget->getAttributes();
if ($lstAttributes->isEmpty()) {
    return;
}
?>
<div class="listivo-print-attributes">
    <?php foreach ($lstAttributes as $lstAttribute) : ?>
        <div class="listivo-print-attributes__row">
            <div class="listivo-print-attributes__label">
                <?php echo esc_html($lstAttribute['label']); ?>:
            </div>

            <div class="listivo-print-attributes__value">
                <?php echo esc_html($lstAttribute['value']); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>