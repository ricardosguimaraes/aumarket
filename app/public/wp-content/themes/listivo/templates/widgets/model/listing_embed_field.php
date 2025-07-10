<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingEmbedFieldWidget;

/* @var ListingEmbedFieldWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstEmbedCode = $lstCurrentWidget->getEmbedCode();
if (empty($lstEmbedCode)) {
    return;
}
?>
<div class="listivo-listing-section listivo-widget-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>">
    <?php if ($lstCurrentWidget->showLabel()) : ?>
        <h3 class="listivo-listing-section__label">
            <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
        </h3>
    <?php endif; ?>

    <div
        <?php if (str_contains($lstEmbedCode, 'tiktok-embed')) : ?>
            <?php if ($lstCurrentWidget->forceRation()) : ?>
                class="listivo-listing-section__embed listivo-listing-section__embed--ratio listivo-listing-section__embed--tiktok"
            <?php else : ?>
                class="listivo-listing-section__embed listivo-listing-section__embed--tiktok"
            <?php endif; ?>
        <?php else : ?>
            <?php if ($lstCurrentWidget->forceRation()) : ?>
                class="listivo-listing-section__embed listivo-listing-section__embed--ratio"
            <?php else : ?>
                class="listivo-listing-section__embed listivo-listing-section__embed"
            <?php endif; ?>
        <?php endif; ?>
    >
        <?php echo tdf_filter($lstEmbedCode); ?>
    </div>
</div>