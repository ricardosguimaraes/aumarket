<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingDescriptionWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel || !$lstModel->hasContent()) {
    return;
}
?>
<div class="listivo-listing-section">
    <?php if (!empty($lstCurrentWidget->getLabel())) : ?>
        <h3 class="listivo-listing-section__label">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </h3>
    <?php endif; ?>

    <div class="listivo-listing-section__text">
        <?php $lstModel->displayContent(); ?>
    </div>
</div>
