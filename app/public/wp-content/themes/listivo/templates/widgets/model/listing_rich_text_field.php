<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingRichTextFieldWidget;

/* @var ListingRichTextFieldWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstValue = $lstCurrentWidget->getValue();
if (empty($lstValue)) {
    return;
}
?>
<div class="listivo-listing-section">
    <?php if ($lstCurrentWidget->hasLabel())  : ?>
        <h3 class="listivo-listing-section__label">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </h3>
    <?php endif; ?>

    <div class="listivo-listing-section__text listivo-listing-rich-text-field">
        <?php echo wp_kses_post($lstValue); ?>
    </div>
</div>