<?php

use Tangibledesign\Listivo\Widgets\General\ListingListV2Widget;

/* @var ListingListV2Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-listing-list-v2 listivo-app <?php echo esc_attr($lstCurrentWidget->getFeaturedLabelClasses()); ?>">
    <div class="listivo-listing-list-v2__top">
        <div class="listivo-listing-list-v2__heading">
            <div class="listivo-heading-v2 listivo-heading-v2--left listivo-heading-v2--tablet-left listivo-heading-v2--mobile-left">
                <?php if ($lstCurrentWidget->hasSmallHeading())  : ?>
                    <h3 class="listivo-heading-v2__small-text">
                        <?php echo esc_html($lstCurrentWidget->getSmallHeading()); ?>
                    </h3>
                <?php endif; ?>

                <h2 class="listivo-heading-v2__text">
                    <?php echo wp_kses_post(nl2br($lstCurrentWidget->getHeading())); ?>
                </h2>
            </div>
        </div>

        <div class="listivo-listing-list-v2__button">
            <a
                    class="listivo-button listivo-button--primary-1"
                    href="<?php echo esc_url($lstCurrentWidget->getUrl()); ?>"
            >
                <span>
                    <?php echo esc_html($lstCurrentWidget->getText()); ?>

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

    <div class="listivo-listing-list-v2__content">
        <?php
        global $lstCurrentListing, $lstModelCard;
        foreach ($lstCurrentWidget->getListings() as $lstCurrentListing) :
            $lstModelCard = $lstCurrentWidget->getCardConfig($lstCurrentListing);
            $lstCurrentWidget->loadCardTemplate();
        endforeach;
        ?>
    </div>

    <div class="listivo-listing-list-v2__mobile-button">
        <a
                class="listivo-button listivo-button--primary-1"
                href="<?php echo esc_url($lstCurrentWidget->getUrl()); ?>"
        >
            <span>
                <?php echo esc_html($lstCurrentWidget->getText()); ?>

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
