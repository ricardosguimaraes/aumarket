<?php

use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Listivo\Widgets\PrintModel\PrintListingImageWidget;

/* @var PrintListingImageWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstImages = $lstCurrentWidget->getImages();
$lstImage = $lstImages->first(false);
if (!$lstImage instanceof Image) {
    return;
}
?>
<div class="listivo-print-image">
    <img
            src="<?php echo esc_url($lstImage->getImageUrl()); ?>"
            alt="<?php echo esc_attr($lstImage->getAlt()); ?>"
    >
</div>