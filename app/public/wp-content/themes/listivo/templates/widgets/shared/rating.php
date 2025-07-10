<?php
/* @var \Tangibledesign\Listivo\Traits\Widgets\RatingContentControlsTrait $lstCurrentWidget */
global $lstCurrentWidget;

$lstReviewSubject = $lstCurrentWidget->getReviewSubject();
if (!$lstReviewSubject) {
    return;
}

$lstRating = $lstReviewSubject->getRating();
$lstRatingCount = $lstReviewSubject->getReviewNumber();

if (empty($lstRatingCount)) {
    return;
}
?>
<div class="listivo-rating listivo-app">
    <?php if ($lstCurrentWidget->showRating()): ?>
        <div class="listivo-rating__rating">
            <?php echo esc_html($lstRating); ?>
        </div>
    <?php endif; ?>

    <?php if ($lstCurrentWidget->showStars()): ?>
        <div class="listivo-rating__stars">
            <div class="listivo-rating__active-rating">
                <div class="listivo-rating__stars">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                        <div
                                class="listivo-rating__star listivo-rating__star--active"
                            <?php if ($i > $lstRating && $lstRating - $i > -1) : ?>
                                style="width: <?php echo esc_attr(($lstRating - $i + 1) * 16); ?>px;"
                            <?php elseif ($i > $lstRating) : ?>
                                style="width: 0;"
                            <?php endif; ?>
                        >
                            <div class="listivo-rating__star-wrapper">
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
                <div class="listivo-rating__star">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25" viewBox="0 0 26 25"
                         fill="none">
                        <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                        />
                    </svg>
                </div>
            <?php endfor; ?>
        </div>
    <?php endif; ?>

    <?php if ($lstCurrentWidget->showRatingCount()): ?>
        <template>
            <lst-scroll-to selector=".listivo-reviews__list--<?php echo esc_attr($lstReviewSubject->getId()); ?>">
                <div
                        slot-scope="props"
                        class="listivo-rating__count"
                        :class="{'listivo-rating__count--clickable': props.visible}"
                        @click="props.onClick"
                >
                    <?php
                    $lstReviewText = $lstRatingCount === 1 ? tdf_string('review') : tdf_string('reviews');

                    echo sprintf('%d %s', $lstRatingCount, $lstReviewText);
                    ?>
                </div>
            </lst-scroll-to>
        </template>
    <?php endif; ?>
</div>