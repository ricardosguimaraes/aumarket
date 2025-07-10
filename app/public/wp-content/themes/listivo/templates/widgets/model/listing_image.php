<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingImageWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstImage = $lstCurrentWidget->getImage();
if (!$lstImage) {
    return;
}
?>
<div class="listivo-listing-single-image">
    <img
            src="<?php echo esc_url($lstImage->getUrl()); ?>"
            alt="<?php echo esc_attr($lstImage->getAlt()); ?>"
    >
</div>