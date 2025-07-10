<?php

use Tangibledesign\Listivo\Widgets\General\ListingCarouselWithTabsWidget;

/* @var ListingCarouselWithTabsWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstModels = $lstCurrentWidget->getListings();
?>
<div class="listivo-app">
    <lst-listing-carousel-with-tabs
            initial-tab="all"
            request-url="<?php echo esc_url(admin_url('admin-ajax.php?action=listivo/listingCarouselWithTabsWidget/listings')); ?>"
            :limit="<?php echo esc_attr($lstCurrentWidget->getLimit()); ?>"
            :include-excluded="<?php echo esc_attr($lstCurrentWidget->includeExcluded() ? 'true' : 'false'); ?>"
            :swiper-config="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getSwiperConfig())); ?>"
            card-type="<?php echo esc_attr($lstCurrentWidget->getCardType()); ?>"
    >
        <div slot-scope="props" class="listivo-listing-carousel-with-tabs">
            <div class="listivo-listing-carousel-with-tabs-heading-mobile">
                <div class="listivo-heading listivo-heading--left">

                    <?php if (!empty($lstCurrentWidget->getSmallText())) : ?>
                        <div class="listivo-heading__small-text">

                            <?php echo esc_html($lstCurrentWidget->getSmallText()); ?>
                            <div class="listivo-heading__small-text__svg-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="1" viewBox="0 0 25 1">
                                    <g>
                                        <g>
                                            <path d="M10 0h15v1H10z"></path>
                                        </g>
                                        <g>
                                            <path d="M0 0h5v1H0z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="listivo-heading__main">
                        <div class="listivo-heading__text">
                            <h2><?php echo nl2br(esc_html($lstCurrentWidget->getText())); ?></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="listivo-listing-carousel-with-tabs__header">
                <div class="listivo-heading">
                    <?php if (!empty($lstCurrentWidget->getSmallText())) : ?>
                        <div class="listivo-heading__small-text">
                            <?php echo esc_html($lstCurrentWidget->getSmallText()); ?>
                            <div class="listivo-heading__small-text__svg-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="1" viewBox="0 0 25 1">
                                    <g>
                                        <g>
                                            <path d="M10 0h15v1H10z"></path>
                                        </g>
                                        <g>
                                            <path d="M0 0h5v1H0z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="listivo-heading__main">
                        <div class="listivo-heading__text">
                            <h2>
                                <?php echo nl2br(esc_html($lstCurrentWidget->getText())); ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="listivo-listing-carousel-with-tabs__nav">
                    <button
                            @click.prevent="props.prev"
                            class="listivo-arrow"
                    >
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <button
                            @click.prevent="props.next"
                            class="listivo-arrow"
                    >
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>

            <div class="listivo-listing-carousel-with-tabs__tabs">
                <div class="listivo-tabs">
                    <?php foreach ($lstCurrentWidget->getTabs() as $lstTab) : ?>
                        <button
                                class="listivo-tab"
                                :class="{'listivo-tab--active': props.tab === '<?php echo esc_attr($lstTab['key']); ?>'}"
                                @click.prevent="props.setTab('<?php echo esc_attr($lstTab['key']); ?>')"
                        >
                            <?php echo esc_html($lstTab['name']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="listivo-listing-carousel-with-tabs__carousel">
                <div class="listivo-swiper-container">
                    <div class="listivo-swiper-wrapper">
                        <?php
                        global $lstCurrentListing;
                        foreach ($lstModels as $lstCurrentListing) : ?>
                            <div class="listivo-swiper-slide">
                                <?php $lstCurrentWidget->loadCard(); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </lst-listing-carousel-with-tabs>
</div>