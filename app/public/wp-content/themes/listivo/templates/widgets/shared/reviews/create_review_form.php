<?php

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Listivo\Widgets\Listing\ListingReviewsWidget;

/* @var ListingReviewsWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = tdf_current_user();

$lstReviewSubject = $lstCurrentWidget->getReviewSubject();
if ($lstUser && !$lstUser->isModerator()) {
    if ($lstReviewSubject instanceof Model && $lstReviewSubject->getUserId() === $lstUser->getId()) {
        return;
    }

    if ($lstReviewSubject instanceof User && $lstReviewSubject->getId() === $lstUser->getId()) {
        return;
    }
}
?>
<lst-create-review
        request-url="<?php echo esc_url(tdf_action_url('listivo/reviews/create')); ?>"
        :model-id="<?php echo esc_attr($lstCurrentWidget->getReviewSubjectId()); ?>"
        review-type="<?php echo esc_attr($lstCurrentWidget->getReviewType()); ?>"
        :initial-rating="<?php echo esc_attr($lstCurrentWidget->getInitialRating()); ?>"
    <?php if (tdf_settings()->reviewsImagesEnabled()) : ?>
        td-image-nonce="<?php echo esc_attr(wp_create_nonce('listivo_upload_image')); ?>"
    <?php endif; ?>
    <?php if ($lstUser || tdf_settings()->reviewsAllowGuests()) : ?>
        td-nonce="<?php echo esc_attr(wp_create_nonce('listivo/reviews/create')); ?>"
    <?php endif; ?>
        select-rating-text="<?php echo esc_attr(tdf_string('select_rating')); ?>"
        oops-text="<?php echo esc_attr(tdf_string('oops')); ?>"
        :is-moderation-enabled="<?php echo esc_attr(tdf_settings()->isReviewsModerationEnabled() ? 'true' : 'false'); ?>"
        ok-button-text="<?php echo esc_attr(tdf_string('ok')); ?>"
        cancel-button-text="<?php echo esc_attr(tdf_string('cancel')); ?>"
    <?php if ($lstReviewSubject instanceof User) : ?>
        new-review-confirm-text="<?php echo esc_attr(tdf_string('new_review_confirm_user')); ?>"
    <?php else : ?>
        new-review-confirm-text="<?php echo esc_attr(tdf_string('new_review_confirm_model')); ?>"
    <?php endif; ?>
        :review-min-length="<?php echo esc_attr(tdf_settings()->getReviewMinLength()); ?>"
        review-min-length-title="<?php echo esc_attr(tdf_string('review_min_length_title')); ?>"
        review-min-length-text="<?php echo esc_attr(str_replace('%d', tdf_settings()->getReviewMinLength(), tdf_string('review_min_length_text'))); ?>"
        :review-max-length="<?php echo esc_attr(tdf_settings()->getReviewMaxLength()); ?>"
        review-max-length-title="<?php echo esc_attr(tdf_string('review_max_length_title')); ?>"
        review-max-length-text="<?php echo esc_attr(str_replace('%d', tdf_settings()->getReviewMaxLength(), tdf_string('review_max_length_text'))); ?>"
        image-upload-wait-title="<?php echo esc_attr(tdf_string('image_upload_wait_title')); ?>"
        image-upload-wait-text="<?php echo esc_attr(tdf_string('image_upload_wait_text')); ?>"
        :is-gallery-enabled="<?php echo esc_attr(tdf_settings()->reviewsImagesEnabled() ? 'true' : 'false'); ?>"
        :has-user-already-reviewed="<?php echo esc_attr($lstCurrentWidget->hasUserAlreadyReviewed() ? 'true' : 'false'); ?>"
>
    <form
            class="listivo-review-form"
            slot-scope="createReview"
            @submit.prevent.stop="createReview.onSubmit"
    >
        <div class="listivo-review-form__top">
            <h3 class="listivo-review-form__title">
                <?php echo esc_html(tdf_string('write_a_review')); ?>
            </h3>
        </div>

        <?php if ($lstUser || tdf_settings()->reviewsAllowGuests()) : ?>
            <div class="listivo-review-form__content">
                <div class="listivo-review-form__content-top">
                    <div class="listivo-review-form__user">
                        <?php if ($lstUser) : ?>
                            <?php if ($lstUser->hasImageUrl('listivo_100_100')) : ?>
                                <a
                                        class="listivo-review-form__avatar"
                                        href="<?php echo esc_url($lstUser->getUrl()); ?>"
                                >
                                    <img
                                            class="lazyload"
                                            alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                            data-src="<?php echo esc_url($lstUser->getImageUrl('listivo_100_100')); ?>"
                                    >
                                </a>
                            <?php else : ?>
                                <div class="listivo-review-form__avatar listivo-review-form__avatar--placeholder listivo-user-image-placeholder">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 132 148" fill="none">
                                        <path d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                                              stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                                              stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                            <?php endif; ?>

                            <div class="listivo-review-form__user-data">
                                <div class="listivo-review-form__user-heading">
                                    <?php echo esc_html($lstUser->getDisplayName()); ?>
                                </div>

                                <div class="listivo-review-form__user-subheading">
                                    <?php echo esc_html(tdf_string('your_opinion_matters')) ?>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="listivo-review-form__avatar listivo-review-form__avatar--placeholder listivo-user-image-placeholder">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 132 148" fill="none">
                                    <path d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                                          stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                                          stroke-linejoin="round"></path>
                                </svg>
                            </div>

                            <div class="listivo-review-form__user-data">
                                <div class="listivo-review-form__user-heading">
                                    <?php echo esc_html(tdf_string('post_as_guest')); ?>
                                </div>

                                <div class="listivo-review-form__user-subheading">
                                    <?php echo esc_html(tdf_string('your_opinion_matters')) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="listivo-review-form__rating">
                        <?php for ($i = 1; $i <= 5; $i++) : ?>
                            <svg
                                    @mouseover="createReview.setStarHover(<?php echo esc_attr($i); ?>)"
                                    @mouseout="createReview.setStarHover(0)"
                                    @click.prevent.stop="createReview.setStar(<?php echo esc_attr($i); ?>)"
                                    class="listivo-review-form__star"
                                    :class="{
                                        'listivo-review-form__star--active': createReview.currentStarHover === 0 && createReview.currentStar >= <?php echo esc_attr($i); ?>,
                                        'listivo-review-form__star--hover': createReview.currentStarHover >= <?php echo esc_attr($i); ?>,
                                    }"
                                    xmlns="http://www.w3.org/2000/svg"
                                    width="30" height="30" viewBox="0 0 30 30" fill="none"
                            >
                                <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
                            </svg>
                        <?php endfor; ?>
                    </div>
                </div>

                <?php if (tdf_settings()->reviewsImagesEnabled()) : ?>
                    <div class="listivo-review-form__attachments">
                        <div class="listivo-review-photos">
                            <lst-dropzone
                                    id="listivo-review-form-dropzone"
                                    :options="<?php echo htmlspecialchars(json_encode($lstCurrentWidget->getDropzoneConfig())); ?>"
                                    @vdropzone-sending="createReview.onSendingImage"
                                    @vdropzone-success="createReview.onSuccessImage"
                                    @vdropzone-removed-file="createReview.onRemovedImage"
                                    @vdropzone-queue-complete="createReview.onQueueComplete"
                                    :use-custom-slot="false"
                            />
                        </div>
                    </div>

                    <div
                            class="listivo-review-form__attachments-label"
                            @click.prevent.stop="createReview.openDropzone"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="20" viewBox="0 0 17 20"
                             fill="none">
                            <path d="M11.9541 0C10.7227 0 9.49249 0.487863 8.57004 1.46106L1.87692 8.52148C-0.625641 11.1624 -0.625641 15.4077 1.87692 18.0486C1.95407 18.1299 2.04679 18.1948 2.14955 18.2396C2.15118 18.2401 2.15281 18.2407 2.15444 18.2412C4.67582 20.6305 8.60879 20.6038 11.0302 18.0486L15.7382 13.081C15.8179 13.0022 15.881 12.9082 15.9236 12.8045C15.9662 12.7009 15.9876 12.5897 15.9864 12.4776C15.9852 12.3656 15.9615 12.2549 15.9167 12.1522C15.8719 12.0495 15.8068 11.9568 15.7255 11.8797C15.6441 11.8026 15.5481 11.7427 15.4431 11.7035C15.3381 11.6642 15.2263 11.6465 15.1144 11.6514C15.0024 11.6562 14.8925 11.6835 14.7913 11.7317C14.6901 11.7799 14.5997 11.8479 14.5253 11.9317L9.81725 16.8993C7.93516 18.8854 4.97357 18.8854 3.09148 16.8993C1.20932 14.9131 1.20932 11.657 3.09148 9.67074L9.78297 2.61032C11.0072 1.31873 12.9027 1.31873 14.127 2.61032C15.3511 3.90178 15.3511 6.03342 14.127 7.32488L8.03623 13.7519C7.46878 14.3502 6.64048 14.3497 6.074 13.7519C5.50751 13.1541 5.50751 12.1475 6.074 11.5497L10.973 6.37968C11.0527 6.30089 11.1158 6.20688 11.1584 6.10324C11.2011 5.99959 11.2224 5.88843 11.2212 5.77636C11.22 5.6643 11.1963 5.55361 11.1515 5.45089C11.1067 5.34818 11.0417 5.25552 10.9603 5.17844C10.8789 5.10135 10.7829 5.04142 10.6779 5.00219C10.573 4.96296 10.4612 4.94525 10.3492 4.9501C10.2372 4.95495 10.1274 4.98227 10.0262 5.03042C9.92498 5.07858 9.83449 5.1466 9.76011 5.23043L4.85944 10.4005C3.67238 11.6532 3.67238 13.6485 4.85944 14.9012C4.93867 14.9845 5.03426 15.0507 5.14023 15.0954C6.34435 16.1014 8.14311 16.0673 9.24915 14.9012L15.3399 8.47414C17.1088 6.60793 17.1342 3.68735 15.5113 1.73205C15.4722 1.6315 15.414 1.53948 15.3399 1.46106C14.4174 0.487863 13.1856 0 11.9541 0Z"
                                  fill="#374B5C"/>
                        </svg>

                        <?php echo esc_html(tdf_string('add_photos')); ?>
                    </div>
                <?php endif; ?>

                <?php if (!$lstUser && tdf_settings()->reviewsAllowGuests()) : ?>
                    <div class="listivo-input-v2 listivo-review-form__name">
                        <input
                                type="text"
                                @input="createReview.setAuthor($event.target.value)"
                                :value="createReview.author"
                                placeholder="<?php echo esc_attr(tdf_string('your_name')); ?>"
                                minlength="3"
                                required
                        >
                    </div>
                <?php endif; ?>

                <textarea
                        class="listivo-review-form__textarea"
                        @input="createReview.setReview($event.target.value)"
                        :value="createReview.review"
                        placeholder="<?php echo esc_attr(tdf_string('write_your_review')); ?>"
                        cols="30"
                        rows="10"
                ></textarea>

                <?php if (!empty(tdf_settings()->getReviewMinLength()) || !empty(tdf_settings()->getReviewMaxLength())) : ?>
                    <div class="listivo-review-form__character-limit">
                        <?php if (!empty(tdf_settings()->getReviewMinLength())) : ?>
                            <div
                                    class="listivo-review-form__character-counter"
                                    :class="{'listivo-review-form__character-counter--valid': createReview.review.length >= <?php echo esc_attr(tdf_settings()->getReviewMinLength()); ?> }"
                            >
                                <?php echo esc_html(tdf_string('minimum_characters') . ': ') . tdf_settings()->getReviewMinLength(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty(tdf_settings()->getReviewMaxLength())) : ?>
                            <template>
                                <div
                                        class="listivo-review-form__character-counter"
                                        :class="{'listivo-review-form__character-counter--error': createReview.review.length > <?php echo esc_attr(tdf_settings()->getReviewMaxLength()); ?> }"
                                >{{ createReview.review.length
                                    }}/<?php echo esc_html(tdf_settings()->getReviewMaxLength()); ?> <?php echo esc_html(tdf_string('characters')); ?>
                                </div>
                            </template>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="listivo-review-form__bottom">
                    <button
                        <?php if ($lstCurrentWidget->isPrimary1ButtonType()) : ?>
                            class="listivo-button listivo-button--primary-1"
                        <?php else : ?>
                            class="listivo-button listivo-button--primary-2"
                        <?php endif; ?>
                            :class="{'listivo-button--loading': createReview.inProgress}"
                            :disabled="createReview.inProgress"
                    >
                        <span>
                            <?php echo esc_html(tdf_string('submit_a_review')); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                 fill="none">
                                <path
                                        d="M5.00488 11.525V7.075H0.854883V5.125H5.00488V0.65H7.00488V5.125H11.1549V7.075H7.00488V11.525H5.00488Z"
                                        fill="#FDFDFE"/>
                            </svg>
                        </span>

                        <template>
                            <svg
                                    width='40'
                                    height='10'
                                    viewBox='0 0 120 30'
                                    xmlns='http://www.w3.org/2000/svg'
                                    fill='#fff'
                                    class="listivo-button__loading"
                            >
                                <circle cx='15' cy='15' r='15'>
                                    <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s'
                                             values='15;9;15'
                                             calcMode='linear' repeatCount='indefinite'/>
                                    <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                             values='1;.5;1'
                                             calcMode='linear' repeatCount='indefinite'/>
                                </circle>

                                <circle cx='60' cy='15' r='9' fill-opacity='0.3'>
                                    <animate attributeName='r' from='9' to='9' begin='0s' dur='0.8s' values='9;15;9'
                                             calcMode='linear' repeatCount='indefinite'/>
                                    <animate attributeName='fill-opacity' from='0.5' to='0.5' begin='0s' dur='0.8s'
                                             values='.5;1;.5' calcMode='linear' repeatCount='indefinite'/>
                                </circle>

                                <circle cx='105' cy='15' r='15'>
                                    <animate attributeName='r' from='15' to='15' begin='0s' dur='0.8s'
                                             values='15;9;15'
                                             calcMode='linear' repeatCount='indefinite'/>
                                    <animate attributeName='fill-opacity' from='1' to='1' begin='0s' dur='0.8s'
                                             values='1;.5;1'
                                             calcMode='linear' repeatCount='indefinite'/>
                                </circle>
                            </svg>
                        </template>
                    </button>
                </div>
            </div>
        <?php else : ?>
            <div class="listivo-review-form__not-logged">
                <?php
                echo sprintf(
                    esc_html(tdf_string('you_must_login_or_register_to_post_a_review')),
                    '<a href="' . esc_url(tdf_settings()->getLoginPageUrl()) . '">' . tdf_string('log_in') . '</a>',
                    '<a href="' . esc_url(tdf_settings()->getRegisterPageUrl()) . '">' . tdf_string('register') . '</a>',
                );
                ?>
            </div>
        <?php endif; ?>
    </form>
</lst-create-review>