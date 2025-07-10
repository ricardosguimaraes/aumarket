<?php

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Listivo\Widgets\General\MiniListingCarouselWidget;

/* @var MiniListingCarouselWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModels = $lstCurrentWidget->getListings();
if ($lstModels->isEmpty()) {
    return;
}

$lstImageSize = tdf_app('listing_card_image_size');
?>
<div class="listivo-app">
    <lst-listing-carousel
            prefix="listivo"
            :swiper-config="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getSwiperConfig())); ?>"
    >
        <div slot-scope="props" class="listivo-mini-listing-carousel">
            <h4 class="listivo-mini-listing-carousel__label">
                <?php echo esc_html($lstCurrentWidget->getLabel()); ?>
            </h4>

            <div class="listivo-mini-listing-carousel__listings">
                <div class="listivo-swiper-container">
                    <div class="listivo-swiper-wrapper">
                        <?php foreach ($lstModels as $lstModel) :
                            /* @var Model $lstModel */
                            ?>
                            <div class="listivo-swiper-slide">
                                <div class="listivo-mini-listing-carousel-card">
                                    <a
                                            class="listivo-mini-listing-carousel-card__image"
                                            href="<?php echo esc_url($lstModel->getUrl()); ?>"
                                    >
                                        <?php
                                        $lstImage = $lstModel->getMainImage();
                                        if ($lstImage) :
                                            $lstImageSrcset = $lstImage->getSrcset($lstImageSize['key']);
                                            ?>
                                            <img
                                                    class="lazyload"
                                                    src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                    alt="<?php echo esc_attr($lstModel->getName()); ?>"
                                                <?php if (!empty($lstImageSrcset)) : ?>
                                                    data-srcset="<?php echo esc_attr($lstImageSrcset); ?>"
                                                    data-sizes="auto"
                                                <?php else : ?>
                                                    data-src="<?php echo esc_url($lstImage->getImageUrl($lstImageSize['key'])); ?>"
                                                <?php endif; ?>
                                            >
                                        <?php else : ?>
                                            <img
                                                    class="lazyload"
                                                    src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw=="
                                                    alt="<?php echo esc_attr($lstModel->getName()); ?>"
                                            >

                                            <?php get_template_part('templates/partials/image_placeholder'); ?>
                                        <?php endif; ?>
                                    </a>

                                    <div class="listivo-mini-listing-carousel-card__body">
                                        <a
                                                class="listivo-mini-listing-carousel-card__name"
                                                href="<?php echo esc_url($lstModel->getUrl()); ?>"
                                        >
                                            <?php echo esc_html($lstModel->getName()); ?>
                                        </a>

                                        <?php if (!empty($lstModel->getAddress())) : ?>
                                            <div class="listivo-mini-listing-carousel-card__address">
                                                <div class="listivo-mini-listing-carousel-card__address-icon-wrapper">
                                                    <div class="listivo-mini-listing-carousel-card__address-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14"
                                                             viewBox="0 0 10 14" fill="none">
                                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M5 0C2.24609 0 0 2.27981 0 5.07505C0 5.8601 0.316406 6.72048 0.753906 7.62843C1.19141 8.54036 1.76172 9.49193 2.33594 10.3602C3.4729 12.0952 4.60597 13.5072 4.61325 13.5162C4.61347 13.5165 4.61339 13.5164 4.61362 13.5167C4.81166 13.7644 5.18835 13.7644 5.38638 13.5167C5.38661 13.5164 5.38653 13.5165 5.38675 13.5162C5.39402 13.5072 6.52712 12.0952 7.66797 10.3602C8.23828 9.49193 8.80859 8.54036 9.24609 7.62843C9.68359 6.72048 10 5.8601 10 5.07505C10 2.27981 7.75391 0 5 0ZM5 1.01514C7.21484 1.01514 9 2.82709 9 5.07518C9 5.55096 8.75391 6.33997 8.34766 7.18449C7.94141 8.03298 7.38672 8.95283 6.83594 9.80132C5.99563 11.0789 5.40082 11.8315 5.08146 12.2356C5.03992 12.2882 4.96008 12.2883 4.91854 12.2356C4.59919 11.8315 4.00437 11.0789 3.16406 9.80132C2.61328 8.95283 2.05859 8.03298 1.65234 7.18449C1.24609 6.33997 1 5.55096 1 5.07518C1 2.82709 2.78516 1.01514 5 1.01514ZM4.00002 5.06006C4.00002 4.50928 4.44924 4.06006 5.00002 4.06006C5.5508 4.06006 6.00002 4.50928 6.00002 5.06006C6.00002 5.61084 5.5508 6.06006 5.00002 6.06006C4.44924 6.06006 4.00002 5.61084 4.00002 5.06006Z"
                                                                  fill="#374B5C"/>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <div class="listivo-mini-listing-carousel-card__address-text">
                                                    <?php echo esc_html($lstModel->getAddress()); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty($lstModel->getPrice())) : ?>
                                            <div class="listivo-mini-listing-carousel-card__price">
                                                <?php echo esc_html($lstModel->getPrice()); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="listivo-mini-listing-carousel__bottom">
                <div class="listivo-mini-listing-carousel__count">
                    <template>
                        {{ props.swiper.activeIndex + 1 }} / <?php echo esc_html($lstModels->count()); ?>
                    </template>
                </div>

                <div class="listivo-mini-listing-carousel__nav">
                    <div
                            @click="props.prevSlide"
                            class="listivo-box-arrow"
                            :class="{'listivo-box-arrow--disabled': props.swiper.isBeginning}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                             fill="none">
                            <path
                                    d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"/>
                        </svg>
                    </div>

                    <div
                            @click="props.nextSlide"
                            class="listivo-box-arrow"
                            :class="{'listivo-box-arrow--disabled': props.swiper.isEnd}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                             fill="none">
                            <path
                                    d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49604 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455587 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </lst-listing-carousel>
</div>