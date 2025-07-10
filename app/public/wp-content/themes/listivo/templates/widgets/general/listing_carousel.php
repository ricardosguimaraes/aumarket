<?php

use Tangibledesign\Listivo\Widgets\General\ListingCarouselWidget;

/* @var ListingCarouselWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-app">
    <lst-listing-carousel
            prefix="listivo"
            :swiper-config="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getSwiperConfig())); ?>"
    >
        <div slot-scope="props" class="listivo-listing-carousel">
            <div class="listivo-listing-carousel__top">
                <div class="listivo-heading-v2 listivo-heading-v2--left listivo-heading-v2--tablet-center listivo-heading-v2--mobile-center">
                    <?php if ($lstCurrentWidget->hasSmallHeading())  : ?>
                        <h3 class="listivo-heading-v2__small-text">
                            <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
                        </h3>
                    <?php endif; ?>

                    <h2 class="listivo-heading-v2__text">
                        <?php echo wp_kses_post(nl2br($lstCurrentWidget->getHeading())); ?>
                    </h2>
                </div>

                <div class="listivo-listing-carousel__right listivo-listing-carousel__right--tablet-visible">
                    <div class="listivo-listing-carousel__nav">
                        <div class="listivo-box-arrows">
                            <div
                                    @click="props.prevSlide"
                                    class="listivo-box-arrow"
                                    :class="{'listivo-box-arrow--disabled': props.swiper.isBeginning}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                     fill="none">
                                    <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"/>
                                </svg>
                            </div>

                            <div
                                    @click="props.nextSlide"
                                    class="listivo-box-arrow"
                                    :class="{'listivo-box-arrow--disabled': props.swiper.isEnd}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                     fill="none">
                                    <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49604 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455587 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="listivo-listing-carousel__button listivo-listing-carousel__button--v2 listivo-listing-carousel__button--margin-left">
                        <a
                                class="listivo-button listivo-button--primary-1"
                                href="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
                        >
                            <span>
                                <?php echo esc_html(tdf_string('view_all')); ?>

                                <svg width="8" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14">
                                    <g>
                                        <g>
                                            <path d="M7.33974,6.18666v0l-5.45414,-5.86846c-0.24639,-0.30357 -0.50858,-0.30357 -0.78587,0l-0.32364,0.35442c-0.24616,0.26968 -0.24616,0.55668 0,0.85987l4.71474,5.05868v0l-4.71474,5.05905c-0.27718,0.30282 -0.27718,0.58982 0,0.8595l0.32364,0.35404c0.27729,0.30395 0.53947,0.30395 0.78587,0l5.45414,-5.86846c0.24696,-0.26892 0.24696,-0.5386 0,-0.80865z"
                                                  fill="#ffffff" fill-opacity="1"></path>
                                        </g>
                                    </g>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="listivo-listing-carousel__content">
                <div class="listivo-swiper-container">
                    <div class="listivo-swiper-wrapper">
                        <?php
                        global $lstCurrentListing;
                        foreach ($lstCurrentWidget->getListings() as $lstCurrentListing) : ?>
                            <div class="listivo-swiper-slide">
                                <?php $lstCurrentWidget->loadCardTemplate(); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="listivo-listing-carousel__mobile-bottom listivo-listing-carousel__mobile-bottom--v2">
                <a
                        class="listivo-button listivo-button--primary-1"
                        href="<?php echo esc_url(get_post_type_archive_link(tdf_model_post_type())); ?>"
                >
                    <span>
                        <?php echo esc_html(tdf_string('view_all')); ?>

                        <svg width="8" height="14" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8 14">
                            <g>
                                <g>
                                    <path d="M7.33974,6.18666v0l-5.45414,-5.86846c-0.24639,-0.30357 -0.50858,-0.30357 -0.78587,0l-0.32364,0.35442c-0.24616,0.26968 -0.24616,0.55668 0,0.85987l4.71474,5.05868v0l-4.71474,5.05905c-0.27718,0.30282 -0.27718,0.58982 0,0.8595l0.32364,0.35404c0.27729,0.30395 0.53947,0.30395 0.78587,0l5.45414,-5.86846c0.24696,-0.26892 0.24696,-0.5386 0,-0.80865z"
                                          fill="#ffffff" fill-opacity="1"></path>
                                </g>
                            </g>
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </lst-listing-carousel>
</div>