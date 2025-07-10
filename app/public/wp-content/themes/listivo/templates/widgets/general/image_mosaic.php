<?php

use Tangibledesign\Listivo\Widgets\General\ImageMosaicWidget;

/* @var ImageMosaicWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-image-mosaic">
    <?php for ($i = 1; $i <= 13; $i++) : ?>
        <?php if (!empty($lstCurrentWidget->getImageUrl($i))) : ?>
            <div class="listivo-image-mosaic__image listivo-image-mosaic__image--<?php echo esc_attr($i); ?>">
                <img
                        class="lazyload"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                        data-src="<?php echo esc_url($lstCurrentWidget->getImageUrl($i)); ?>"
                        alt="<?php echo esc_attr($i); ?>"
                >
            </div>
        <?php endif; ?>
    <?php endfor; ?>
</div>
