<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingReviewsWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstReviewSubject = $lstCurrentWidget->getReviewSubject();
?>
<lst-reviews
        class="listivo-reviews__button-wrapper"
        request-url="<?php echo esc_url(tdf_action_url('listivo/reviews/load')); ?>"
        :model-id="<?php echo esc_attr($lstReviewSubject->getId()); ?>"
        review-type="<?php echo esc_attr($lstCurrentWidget->getReviewType()); ?>"
        :limit="<?php echo esc_attr($lstCurrentWidget->getReviewsLimit()); ?>"
        td-nonce="<?php echo esc_attr(wp_create_nonce('listivo/reviews/load')); ?>"
        reviews-container-wrapper-selector=".listivo-reviews-modal__list-wrapper"
        reviews-container-class="listivo-reviews-modal__list"
        :initial-total-pages="<?php echo esc_attr(ceil($lstReviewSubject->getReviewNumber() / $lstCurrentWidget->getReviewsLimit())); ?>"
>
    <div slot-scope="reviewsProps" class="listivo-reviews__button-wrapper">
        <button
                class="listivo-reviews__button"
                @click.prevent.stop="reviewsProps.onShowAllReviews"
                type="button"
        >
            <?php echo esc_html(tdf_string('show_all_reviews')); ?>
            <span><?php echo esc_html($lstReviewSubject->getReviewNumber()); ?></span>
        </button>

        <template>
            <portal v-if="reviewsProps.showModal" to="footer">
                <div class="listivo-reviews-modal">
                    <div class="listivo-reviews-modal__background"></div>

                    <div class="listivo-reviews-modal__content">
                        <div class="listivo-reviews-modal__inner">
                            <div
                                    class="listivo-reviews-modal__close"
                                    @click="reviewsProps.onCloseModal"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8"
                                     fill="none">
                                    <path d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"/>
                                </svg>
                            </div>

                            <div class="listivo-reviews-modal__main">
                                <div class="listivo-reviews-modal__head">
                                    <div class="listivo-reviews-modal__label">
                                        <?php echo esc_html(tdf_string('reviews')); ?>

                                        <span><?php echo esc_html($lstReviewSubject->getReviewNumber()); ?></span>
                                    </div>

                                    <?php $lstRating = $lstReviewSubject->getRating(); ?>

                                    <div class="listivo-reviews-modal__right">
                                        <div class="listivo-reviews-modal__rating">
                                            <?php echo esc_html($lstRating); ?>
                                        </div>

                                        <div class="listivo-reviews-modal__stars">
                                            <div class="listivo-reviews-modal__active-rating">
                                                <div class="listivo-reviews-modal__stars">
                                                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                                                        <div
                                                                class="listivo-reviews-modal__star listivo-reviews-modal__star--active"
                                                            <?php if ($i > $lstRating && $lstRating - $i > -1) : ?>
                                                                style="width: <?php echo esc_attr(($lstRating - $i + 1) * 26); ?>px;"
                                                            <?php elseif ($i > $lstRating) : ?>
                                                                style="width: 0;"
                                                            <?php endif; ?>
                                                        >
                                                            <div class="listivo-reviews-modal__star-wrapper">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="26"
                                                                     height="25"
                                                                     viewBox="0 0 26 25">
                                                                    <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                                                    />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>

                                            <div class="listivo-reviews-modal__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25"
                                                     viewBox="0 0 26 25">
                                                    <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                                    />
                                                </svg>
                                            </div>

                                            <div class="listivo-reviews-modal__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25"
                                                     viewBox="0 0 26 25">
                                                    <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                                    />
                                                </svg>
                                            </div>

                                            <div class="listivo-reviews-modal__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25"
                                                     viewBox="0 0 26 25">
                                                    <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                                    />
                                                </svg>
                                            </div>

                                            <div class="listivo-reviews-modal__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25"
                                                     viewBox="0 0 26 25">
                                                    <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                                    />
                                                </svg>
                                            </div>

                                            <div class="listivo-reviews-modal__star">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="25"
                                                     viewBox="0 0 26 25">
                                                    <path d="M12.9987 20.6139L19.21 24.3626C20.19 24.9539 21.3987 24.0751 21.1387 22.9614L19.49 15.8951L24.9787 11.1401C25.8437 10.3914 25.3812 8.97014 24.2412 8.87389L17.0162 8.26139L14.19 1.59264C13.7437 0.541387 12.2537 0.541387 11.8075 1.59264L8.98124 8.26139L1.75624 8.87389C0.616237 8.97014 0.153736 10.3914 1.01874 11.1401L6.50749 15.8951L4.85874 22.9614C4.59874 24.0751 5.80749 24.9539 6.78749 24.3626L12.9987 20.6139Z"
                                                    />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="listivo-reviews-modal__filters">
                                    <div class="listivo-reviews-modal__filter">
                                        <div class="listivo-reviews-modal__filter-label">
                                            <?php echo esc_html(tdf_string('sort_by')); ?>
                                        </div>

                                        <div class="listivo-reviews-modal__filter-select-wrapper">
                                            <lst-select
                                                    class="listivo-select-v2 listivo-select-v2--small listivo-select-v2--width-auto"
                                                    :options="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getSortByOptions())); ?>"
                                                    @input="reviewsProps.setSortBy"
                                                    :is-selected="reviewsProps.isSortBy"
                                                    active-text-class="listivo-select-v2__option--highlight-text"
                                                    highlight-option-class="listivo-select-v2__option--highlight"
                                                    order-type="none"
                                            >
                                                <div
                                                        slot-scope="select"
                                                        @focusin="select.focusIn"
                                                        @focusout="select.focusOut"
                                                        @keyup.esc="select.onClose"
                                                        @keyup.up="select.decreaseOptionIndex"
                                                        @keyup.down="select.increaseOptionIndex"
                                                        @keyup.enter="select.setOptionByIndex"
                                                        tabindex="0"
                                                        @click="select.onOpen"
                                                        class="listivo-select-v2 listivo-select-v2--small listivo-select-v2--width-auto"
                                                        :class="{
                                                        'listivo-select-v2--open': select.open
                                                    }"
                                                >
                                                    <div
                                                            class="listivo-select-v2__placeholder"
                                                            v-html="select.getOptionById(reviewsProps.sortBy).name"
                                                    ></div>

                                                    <div class="listivo-select-v2__arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5"
                                                             viewBox="0 0 7 5" fill="none">
                                                            <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                                                  fill="#2A3946"/>
                                                        </svg>
                                                    </div>

                                                    <template>
                                                        <div
                                                                v-if="select.open"
                                                                class="listivo-select-v2__dropdown listivo-select-v2__dropdown--auto-width"
                                                        >
                                                            <div
                                                                    v-for="(option, index) in select.options"
                                                                    :key="option.id"
                                                                    @click="select.setOption(option)"
                                                                    class="listivo-select-v2__option"
                                                                    :class="{
                                                                        'listivo-select-v2__option--active': option.selected,
                                                                        'listivo-select-v2__option--highlight': index === select.optionIndex,
                                                                        'listivo-select-v2__option--disabled': option.disabled && !option.selected,
                                                                    }"
                                                            >
                                                                <div
                                                                        class="listivo-select-v2__value"
                                                                        v-html="option.label"
                                                                ></div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </lst-select>
                                        </div>
                                    </div>

                                    <div class="listivo-reviews-modal__filter">
                                        <div class="listivo-reviews-modal__filter-label">
                                            <?php echo esc_html(tdf_string('filter_by_rating')); ?>
                                        </div>

                                        <div class="listivo-reviews-modal__filter-select-wrapper">
                                            <lst-select
                                                    class="listivo-select-v2 listivo-select-v2--small listivo-select-v2--width-auto"
                                                    :options="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getFilterRatingOptions($lstReviewSubject))); ?>"
                                                    @input="reviewsProps.setFilterRating"
                                                    :is-selected="reviewsProps.isFilterRating"
                                                    active-text-class="listivo-select-v2__option--highlight-text"
                                                    highlight-option-class="listivo-select-v2__option--highlight"
                                                    order-type="none"
                                            >
                                                <div
                                                        slot-scope="select"
                                                        @focusin="select.focusIn"
                                                        @focusout="select.focusOut"
                                                        @keyup.esc="select.onClose"
                                                        @keyup.up="select.decreaseOptionIndex"
                                                        @keyup.down="select.increaseOptionIndex"
                                                        @keyup.enter="select.setOptionByIndex"
                                                        tabindex="0"
                                                        @click="select.onOpen"
                                                        class="listivo-select-v2 listivo-select-v2--small listivo-select-v2--width-auto"
                                                        :class="{
                                                            'listivo-select-v2--open': select.open
                                                        }"
                                                >
                                                    <div
                                                            class="listivo-select-v2__placeholder"
                                                            v-html="select.getOptionById(reviewsProps.filterRating).name"
                                                    ></div>

                                                    <div class="listivo-select-v2__arrow">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5"
                                                             viewBox="0 0 7 5" fill="none">
                                                            <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                                                                  fill="#2A3946"/>
                                                        </svg>
                                                    </div>

                                                    <template>
                                                        <div
                                                                v-if="select.open"
                                                                class="listivo-select-v2__dropdown listivo-select-v2__dropdown--auto-width"
                                                        >
                                                            <div
                                                                    v-for="(option, index) in select.options"
                                                                    :key="option.id"
                                                                    @click="select.setOption(option)"
                                                                    class="listivo-select-v2__option"
                                                                    :class="{
                                                                        'listivo-select-v2__option--active': option.selected,
                                                                        'listivo-select-v2__option--highlight': index === select.optionIndex,
                                                                        'listivo-select-v2__option--disabled': option.disabled && !option.selected,
                                                                    }"
                                                            >
                                                                <div
                                                                        class="listivo-select-v2__value"
                                                                        v-html="option.label"
                                                                ></div>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </lst-select>
                                        </div>
                                    </div>
                                </div>

                                <div class="listivo-reviews-modal__inner-container">
                                    <div class="listivo-reviews-modal__list-wrapper">
                                        <div class="listivo-reviews-modal__list"></div>
                                    </div>

                                    <template>
                                        <div
                                                class="listivo-reviews-modal__load-more-button-wrapper"
                                                v-if="reviewsProps.totalPages > reviewsProps.currentPage"
                                        >
                                            <button
                                                    class="listivo-reviews-modal__load-more-button"
                                                    @click="reviewsProps.onLoadMoreReviews"
                                                    type="button"
                                            >
                                                <?php echo esc_html(tdf_string('load_more')); ?>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </portal>
        </template>
    </div>
</lst-reviews>