<?php

use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Models\Review;
use Tangibledesign\Listivo\Widgets\Listing\ListingReviewsWidget;

if (!tdf_settings()->reviewsEnabled()) {
    return;
}

/* @var ListingReviewsWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstUser = tdf_current_user();
$lstReviewSubject = $lstCurrentWidget->getReviewSubject();
if (!$lstReviewSubject) {
    return;
}

$lstReviews = $lstCurrentWidget->getReviews($lstReviewSubject);
?>
<div class="listivo-app">
    <?php if ($lstReviews->isNotEmpty()) : ?>
        <div
                id="listivo-reviews-<?php echo esc_attr($lstReviewSubject->getId()); ?>"
                class="listivo-reviews"
        >
            <div class="listivo-reviews__top">
                <div class="listivo-reviews__top-left">
                    <h3 class="listivo-reviews__title">
                        <?php echo esc_html(tdf_string('reviews')); ?>
                    </h3>

                    <div class="listivo-reviews__count">
                        <?php echo esc_html($lstReviewSubject->getReviewNumber()); ?>
                    </div>
                </div>

                <div class="listivo-reviews__top-right">
                    <?php $lstRawRating = $lstReviewSubject->getRawRating(); ?>

                    <div class="listivo-reviews__rating">
                        <?php echo esc_html($lstReviewSubject->getRating()); ?>
                    </div>

                    <div class="listivo-reviews__stars">
                        <div class="listivo-reviews__active-rating">
                            <div class="listivo-reviews__stars">
                                <?php for ($i = 1; $i <= 5; $i++) : ?>
                                    <div
                                            class="listivo-reviews__star listivo-reviews__star--active"
                                        <?php if ($i > $lstRawRating && $lstRawRating - $i > -1) : ?>
                                            style="width: <?php echo esc_attr(($lstReviewSubject->getRawRating() - $i + 1) * 26); ?>px;"
                                        <?php elseif ($i > $lstRawRating) : ?>
                                            style="width: 0;"
                                        <?php endif; ?>
                                    >
                                        <div class="listivo-reviews__star-wrapper">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25"
                                                 viewBox="0 0 26 25">
                                                <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                                />
                                            </svg>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <?php for ($i = 0; $i < 5; $i++) : ?>
                            <div class="listivo-reviews__star">
                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25" viewBox="0 0 26 25"
                                     fill="none">
                                    <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                    />
                                </svg>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

            <div class="listivo-reviews__list listivo-reviews__list--<?php echo esc_attr($lstReviewSubject->getId()); ?>">
                <?php
                global $lstReview;
                foreach ($lstCurrentWidget->getReviews($lstReviewSubject) as $lstReview) :
                    /* @var Review $lstReview */
                    get_template_part('templates/partials/review', null, [
                        'isModal' => false,
                    ]);
                endforeach;
                ?>
            </div>

            <?php get_template_part('templates/widgets/shared/reviews/reviews_modal'); ?>
        </div>
    <?php endif; ?>

    <?php get_template_part('templates/widgets/shared/reviews/create_review_form'); ?>
</div>