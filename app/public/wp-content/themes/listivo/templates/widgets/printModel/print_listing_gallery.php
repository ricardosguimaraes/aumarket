<?php
/* @var \Tangibledesign\Listivo\Widgets\PrintModel\PrintListingGalleryWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstImages = $lstCurrentWidget->getImages();
if ($lstImages->isEmpty()) {
    return;
}

if ($lstCurrentWidget->hasLabel()) :?>
    <h3 class="listivo-print-label listivo-print-label--margin-bottom">
        <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
    </h3>
<?php endif; ?>

<div class="listivo-print-images">
    <?php foreach ($lstImages as $lstImage) : ?>
        <div class="listivo-print-images__image">
            <img
                    src="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                    alt="<?php echo esc_attr($lstImage->getAlt()); ?>"
            >
        </div>
    <?php endforeach; ?>
</div>