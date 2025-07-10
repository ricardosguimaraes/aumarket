<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingGalleryV2Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}

$lstMainImage = $lstModel->getMainImage();
$lstThumbnails = $lstCurrentWidget->getThumbnails();
$lstCount = $lstThumbnails->count();
$lstPlaceholdersCount = 5 - $lstCount;

if (empty($lstCount)) {
    return;
}
?>
<div class="listivo-app">
    <lst-gallery-v2
            image-selector=".listivo-gallery-v2__image"
            button-selector=".listivo-gallery-v2 .listivo-simple-button"
            class="listivo-gallery-v2"
    >
        <div
                slot-scope="props"
                class="listivo-gallery-v2"
        >
            <div
                <?php if ($lstThumbnails->count() > 5) : ?>
                    class="listivo-gallery-v2__images listivo-gallery-v2__images--clear-gap"
                <?php else : ?>
                    class="listivo-gallery-v2__images"
                <?php endif; ?>
            >
                <?php foreach ($lstThumbnails as $lstIndex => $lstImage) : ?>
                    <div
                        <?php if ($lstIndex === 4 && $lstCount > 5) : ?>
                            class="listivo-gallery-v2__image listivo-gallery-v2__image--last"
                        <?php elseif ($lstIndex >= 5) : ?>
                            class="listivo-gallery-v2__image listivo-gallery-v2__image--hidden"
                        <?php else : ?>
                            class="listivo-gallery-v2__image"
                        <?php endif; ?>
                            data-index="<?php echo esc_attr($lstIndex); ?>"
                            data-url="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                            data-width="<?php echo esc_attr($lstImage->getWidth()); ?>"
                            data-height="<?php echo esc_attr($lstImage->getHeight()); ?>"
                    >
                        <?php if ($lstIndex < 5) : ?>
                            <img
                                    src="<?php echo esc_url($lstImage->getImageUrl('large')); ?>"
                                    alt="<?php echo esc_attr($lstImage->getAlt()); ?>"
                            >
                        <?php endif; ?>

                        <?php if ($lstIndex === 4 && $lstCount > 5) : ?>
                            <div class="listivo-gallery-v2__button">
                                <button
                                    <?php if ($lstCurrentWidget->isPrimary1ButtonType()) : ?>
                                        class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-button-primary-1-selector"
                                    <?php else : ?>
                                        class="listivo-simple-button listivo-simple-button--background-primary-2 listivo-button-primary-2-selector"
                                    <?php endif; ?>
                                >
                                    <?php echo esc_html(tdf_string('show_all_photos')); ?>
                                </button>
                            </div>

                            <div class="listivo-gallery-v2__button listivo-gallery-v2__button--mobile">
                                <button
                                    <?php if ($lstCurrentWidget->isPrimary1ButtonType()) : ?>
                                        class="listivo-simple-button listivo-simple-button--background-primary-1 listivo-button-primary-1-selector"
                                    <?php else : ?>
                                        class="listivo-simple-button listivo-simple-button--background-primary-2 listivo-button-primary-2-selector"
                                    <?php endif; ?>
                                >
                                    <?php echo esc_html(tdf_string('show_all')); ?>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <?php for ($lstI = 0; $lstI < $lstPlaceholdersCount; $lstI++) : ?>
                    <div class="listivo-gallery-v2__image listivo-gallery-v2__image--placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="33" height="27" viewBox="0 0 33 27"
                             fill="none">
                            <path d="M5.87661 0.553223C2.85485 0.553223 0.381836 3.0016 0.381836 5.99326V17.5987C0.381836 20.5903 2.85485 23.0387 5.87661 23.0387H23.4599C26.4817 23.0387 28.9547 20.5903 28.9547 17.5987V5.99326C28.9547 3.0016 26.4817 0.553223 23.4599 0.553223H5.87661ZM5.87661 2.72924H23.4599C25.2941 2.72924 26.7568 4.17738 26.7568 5.99326V17.5987C26.7568 17.7246 26.7333 17.8436 26.7196 17.9656L20.7125 12.2111C20.1748 11.6965 19.4721 11.439 18.7693 11.439C18.0665 11.439 17.3638 11.6965 16.8261 12.2111C16.8256 12.2111 16.8251 12.2111 16.8247 12.2111L15.2878 13.683L11.4816 10.0365C10.9439 9.52193 10.2398 9.26437 9.53694 9.26437C8.83411 9.26437 8.1314 9.52193 7.59373 10.0365L2.57975 14.839V5.99326C2.57975 4.17738 4.04246 2.72924 5.87661 2.72924ZM30.42 3.82716V18.324C30.42 21.7237 27.6264 24.4894 24.1925 24.4894H7.71822C8.72193 25.8081 10.3113 26.6654 12.104 26.6654H24.1925C28.8382 26.6654 32.6179 22.9234 32.6179 18.324V8.16928C32.6179 6.3951 31.7519 4.82088 30.42 3.82716ZM21.262 5.63059C20.7762 5.63059 20.3103 5.82164 19.9669 6.16171C19.6234 6.50178 19.4304 6.96301 19.4304 7.44394C19.4304 7.92487 19.6234 8.3861 19.9669 8.72617C20.3103 9.06624 20.7762 9.25728 21.262 9.25728C21.7478 9.25728 22.2136 9.06624 22.5571 8.72617C22.9006 8.3861 23.0936 7.92487 23.0936 7.44394C23.0936 6.96301 22.9006 6.50178 22.5571 6.16171C22.2136 5.82164 21.7478 5.63059 21.262 5.63059ZM9.53837 11.4276C9.68609 11.4276 9.8331 11.4854 9.95334 11.6005L13.7081 15.196L7.7912 20.8627H5.87661C4.1269 20.8627 2.73035 19.5401 2.60407 17.8423L9.12197 11.6005C9.24221 11.4854 9.39064 11.4276 9.53837 11.4276ZM18.7679 13.6036C18.9156 13.6036 19.064 13.6614 19.1843 13.7765V13.7751L25.685 20.0028C25.0998 20.5332 24.3245 20.8627 23.4599 20.8627H10.9521L18.3529 13.7751V13.7765C18.4731 13.6614 18.6202 13.6036 18.7679 13.6036Z"
                                  fill="#D5E3EE"/>
                        </svg>

                        <?php echo esc_html(tdf_string('no_photo')); ?>
                    </div>
                <?php endfor; ?>
            </div>
        </div>
    </lst-gallery-v2>
</div>
