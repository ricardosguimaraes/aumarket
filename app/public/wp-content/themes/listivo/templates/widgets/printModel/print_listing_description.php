<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingDescriptionWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel || !$lstModel->hasContent()) {
    return;
}

?>
<div class="listivo-print-description-wrapper">
    <?php if ($lstCurrentWidget->hasLabel()) : ?>
        <h3 class="listivo-print-label listivo-print-label--margin-bottom">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </h3>
    <?php endif; ?>

    <div class="listivo-print-description">
        <?php $lstModel->displayContent(); ?>
    </div>
</div>