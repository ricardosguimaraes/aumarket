<?php

use Tangibledesign\Framework\Models\Image;

/* @var Image|false $lstTempImage */
/* @var string $lstImageSize */
global $lstTempImage, $lstImageSize;

if ($lstTempImage) :
    $lstTempImageSrcset = $lstTempImage->getSrcset($lstImageSize);
    ?>
    <img
            class="lazyload"
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
            alt="<?php echo esc_attr($lstTempImage->getAlt()); ?>"
        <?php if (!empty($lstTempImageSrcset)) : ?>
            data-srcset="<?php echo esc_attr($lstTempImageSrcset); ?>"
            data-sizes="auto"
        <?php else : ?>
            data-src="<?php echo esc_url($lstTempImage->getImageUrl($lstImageSize)); ?>"
        <?php endif; ?>
    >
<?php else : ?>
    <img
            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
            alt="placeholder"
    >

    <?php get_template_part('templates/partials/image_placeholder'); ?>
<?php endif;
