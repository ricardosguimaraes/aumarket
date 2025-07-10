<?php

use Tangibledesign\Framework\Actions\Reviews\GetInitialThumbStateAction;
use Tangibledesign\Framework\Models\Review;

/* @var Review $lstReview */
global $lstReview;
$lstUser = $lstReview->getUser();
$lstIsModal = $args['isModal'] ?? false;
?>
<div class="listivo-review">
    <div class="listivo-review__header">
        <div class="listivo-review__user">
            <?php if ($lstUser) : ?>
                <?php if ($lstUser->hasImageUrl('listivo_100_100')) : ?>
                    <a
                            class="listivo-review__avatar"
                            href="<?php echo esc_url($lstUser->getUrl()); ?>"
                            target="_blank"
                    >
                        <img
                                class="lazyload"
                                alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                data-src="<?php echo esc_url($lstUser->getImageUrl('listivo_100_100')); ?>"
                        >
                    </a>
                <?php else : ?>
                    <div class="listivo-review__avatar listivo-review__avatar--placeholder listivo-user-image-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 132 148" fill="none">
                            <path d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                                  stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                                  stroke-linejoin="round"></path>
                        </svg>
                    </div>
                <?php endif; ?>

                <div class="listivo-review__user-data">
                    <a
                            class="listivo-review__user-heading"
                            href="<?php echo esc_url($lstUser->getUrl()); ?>"
                            target="_blank"
                    >
                        <?php echo esc_html($lstUser->getDisplayName()); ?>
                    </a>

                    <div class="listivo-review__user-subheading">
                        <?php echo esc_html($lstReview->getPublishDateDiff()); ?>
                    </div>
                </div>
            <?php else : ?>
                <div class="listivo-review__avatar listivo-review__avatar--placeholder listivo-user-image-placeholder">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 132 148" fill="none">
                        <path d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                              stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                              stroke-linejoin="round"></path>
                    </svg>
                </div>

                <div class="listivo-review__user-data">
                    <div class="listivo-review__user-heading">
                        <?php echo esc_html($lstReview->getAuthor()); ?>
                    </div>

                    <div class="listivo-review__user-subheading">
                        <?php echo esc_html($lstReview->getPublishDateDiff()); ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="listivo-review__rating">
        <div
                class="listivo-review__active-rating"
                style="width: <?php echo esc_attr($lstReview->getRating() / 5 * 110); ?>px;"
        >
            <div class="listivo-review__rating listivo-review__rating--active">
                <svg
                        class="listivo-review__star listivo-review__star--active"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20" height="20" viewBox="0 0 30 30" fill="none"
                >
                    <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
                </svg>

                <svg
                        class="listivo-review__star listivo-review__star--active"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20" height="20" viewBox="0 0 30 30" fill="none"
                >
                    <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
                </svg>

                <svg
                        class="listivo-review__star listivo-review__star--active"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20" height="20" viewBox="0 0 30 30" fill="none"
                >
                    <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
                </svg>

                <svg
                        class="listivo-review__star listivo-review__star--active"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20" height="20" viewBox="0 0 30 30" fill="none"
                >
                    <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
                </svg>

                <svg
                        class="listivo-review__star listivo-review__star--active"
                        xmlns="http://www.w3.org/2000/svg"
                        width="20" height="20" viewBox="0 0 30 30" fill="none"
                >
                    <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
                </svg>
            </div>
        </div>

        <svg
                class="listivo-review__star"
                xmlns="http://www.w3.org/2000/svg"
                width="20" height="20" viewBox="0 0 30 30" fill="none"
        >
            <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
        </svg>

        <svg
                class="listivo-review__star"
                xmlns="http://www.w3.org/2000/svg"
                width="20" height="20" viewBox="0 0 30 30" fill="none"
        >
            <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
        </svg>

        <svg
                class="listivo-review__star"
                xmlns="http://www.w3.org/2000/svg"
                width="20" height="20" viewBox="0 0 30 30" fill="none"
        >
            <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
        </svg>

        <svg
                class="listivo-review__star"
                xmlns="http://www.w3.org/2000/svg"
                width="20" height="20" viewBox="0 0 30 30" fill="none"
        >
            <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
        </svg>

        <svg
                class="listivo-review__star"
                xmlns="http://www.w3.org/2000/svg"
                width="20" height="20" viewBox="0 0 30 30" fill="none"
        >
            <path d="M14.9987 22.6139L21.21 26.3626C22.19 26.9539 23.3987 26.0751 23.1387 24.9614L21.49 17.8951L26.9787 13.1401C27.8437 12.3914 27.3812 10.9701 26.2412 10.8739L19.0162 10.2614L16.19 3.59264C15.7437 2.54139 14.2537 2.54139 13.8075 3.59264L10.9812 10.2614L3.75624 10.8739C2.61624 10.9701 2.15374 12.3914 3.01874 13.1401L8.50749 17.8951L6.85874 24.9614C6.59874 26.0751 7.80749 26.9539 8.78749 26.3626L14.9987 22.6139Z"/>
        </svg>
    </div>

    <div class="listivo-review__text">
        <?php if ($lstReview->getContentLength() < tdf_settings()->getReviewCutoffLength()) : ?>
            <?php echo nl2br(esc_html($lstReview->getContent())); ?>
        <?php else : ?>
            <lst-show>
                <div slot-scope="showProps">
                    <div v-if="!showProps.show">
                        <?php echo nl2br(esc_html($lstReview->getContent(tdf_settings()->getReviewCutoffLength()))); ?>

                        <span
                                class="listivo-review__read-more"
                                @click="showProps.onClick"
                        >
                            <?php echo esc_html(tdf_string('read_more')); ?>
                        </span>
                    </div>

                    <template>
                        <div v-if="showProps.show">
                            <?php echo nl2br(esc_html($lstReview->getContent())); ?>
                        </div>
                    </template>
                </div>
            </lst-show>
        <?php endif; ?>
    </div>

    <?php if (tdf_settings()->reviewsImagesEnabled()) :
        $lstImages = $lstReview->getImages();
        if ($lstImages->isNotEmpty()) : ?>
            <lst-review-gallery
                <?php if ($lstIsModal) : ?>
                    :swiper-config="<?php echo htmlspecialchars(json_encode(tdf_app('reviews_modal_swiper_config'))); ?>"
                <?php else : ?>
                    :swiper-config="<?php echo htmlspecialchars(json_encode(tdf_app('reviews_swiper_config'))); ?>"
                <?php endif; ?>
                    nav-prev-selector=".listivo-review-gallery__prev"
                    nav-next-selector=".listivo-review-gallery__next"
            >
                <div
                        class="listivo-review__gallery listivo-review-gallery"
                        slot-scope="galleryProps"
                >
                    <div class="listivo-swiper-container swiper-container">
                        <div class="listivo-review-gallery__prev listivo-swiper-slide-prev">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                 viewBox="0 0 23 23" fill="none">
                                <path d="M3.21493 11.3346C3.2178 11.5187 3.2936 11.694 3.42568 11.8222C3.55775 11.9504 3.7353 12.0209 3.91932 12.0182H17.5207L12.2246 17.3143C12.158 17.3783 12.1048 17.4549 12.0681 17.5397C12.0315 17.6245 12.0121 17.7158 12.0112 17.8082C12.0102 17.9006 12.0277 17.9922 12.0626 18.0778C12.0976 18.1633 12.1492 18.241 12.2145 18.3063C12.2799 18.3717 12.3576 18.4233 12.4431 18.4582C12.5287 18.4932 12.6203 18.5107 12.7127 18.5097C12.8051 18.5088 12.8964 18.4894 12.9812 18.4528C13.066 18.4161 13.1426 18.3629 13.2066 18.2963L19.6881 11.8148C19.8183 11.6845 19.8914 11.5079 19.8914 11.3238C19.8914 11.1396 19.8183 10.963 19.6881 10.8328L13.2066 4.35131C13.1426 4.28466 13.066 4.23145 12.9812 4.1948C12.8964 4.15814 12.8051 4.13878 12.7127 4.13784C12.6203 4.1369 12.5287 4.1544 12.4431 4.18933C12.3576 4.22425 12.2799 4.27589 12.2145 4.34122C12.1492 4.40655 12.0976 4.48426 12.0626 4.5698C12.0277 4.65534 12.0102 4.74699 12.0112 4.83938C12.0121 4.93177 12.0315 5.02304 12.0681 5.10785C12.1048 5.19266 12.158 5.26931 12.2246 5.3333L17.5207 10.6293H3.91932C3.82637 10.628 3.7341 10.6453 3.64798 10.6803C3.56186 10.7153 3.48364 10.7672 3.41795 10.833C3.35226 10.8988 3.30044 10.9771 3.26557 11.0632C3.2307 11.1494 3.21348 11.2417 3.21493 11.3346Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <div class="listivo-review-gallery__next listivo-swiper-slide-next">
                            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23"
                                 viewBox="0 0 23 23" fill="none">
                                <path d="M3.21493 11.3346C3.2178 11.5187 3.2936 11.694 3.42568 11.8222C3.55775 11.9504 3.7353 12.0209 3.91932 12.0182H17.5207L12.2246 17.3143C12.158 17.3783 12.1048 17.4549 12.0681 17.5397C12.0315 17.6245 12.0121 17.7158 12.0112 17.8082C12.0102 17.9006 12.0277 17.9922 12.0626 18.0778C12.0976 18.1633 12.1492 18.241 12.2145 18.3063C12.2799 18.3717 12.3576 18.4233 12.4431 18.4582C12.5287 18.4932 12.6203 18.5107 12.7127 18.5097C12.8051 18.5088 12.8964 18.4894 12.9812 18.4528C13.066 18.4161 13.1426 18.3629 13.2066 18.2963L19.6881 11.8148C19.8183 11.6845 19.8914 11.5079 19.8914 11.3238C19.8914 11.1396 19.8183 10.963 19.6881 10.8328L13.2066 4.35131C13.1426 4.28466 13.066 4.23145 12.9812 4.1948C12.8964 4.15814 12.8051 4.13878 12.7127 4.13784C12.6203 4.1369 12.5287 4.1544 12.4431 4.18933C12.3576 4.22425 12.2799 4.27589 12.2145 4.34122C12.1492 4.40655 12.0976 4.48426 12.0626 4.5698C12.0277 4.65534 12.0102 4.74699 12.0112 4.83938C12.0121 4.93177 12.0315 5.02304 12.0681 5.10785C12.1048 5.19266 12.158 5.26931 12.2246 5.3333L17.5207 10.6293H3.91932C3.82637 10.628 3.7341 10.6453 3.64798 10.6803C3.56186 10.7153 3.48364 10.7672 3.41795 10.833C3.35226 10.8988 3.30044 10.9771 3.26557 11.0632C3.2307 11.1494 3.21348 11.2417 3.21493 11.3346Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </div>

                        <div class="listivo-swiper-wrapper">
                            <?php foreach ($lstReview->getImages() as $lstIndex => $lstImage) :
                                /* @var \Tangibledesign\Framework\Models\Image $lstImage */
                                $lstImageSrcset = $lstImage->getSrcset('listivo_400_400');
                                ?>
                                <div
                                        class="listivo-swiper-slide"
                                        data-index="<?php echo esc_attr($lstIndex); ?>"
                                        data-url="<?php echo esc_url($lstImage->getImageUrl()); ?>"
                                        data-width="<?php echo esc_attr($lstImage->getWidth()); ?>"
                                        data-height="<?php echo esc_attr($lstImage->getHeight()); ?>"
                                >
                                    <div class="listivo-review-gallery__image">
                                        <img
                                                class="lazyload"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                                alt="<?php echo esc_attr($lstImage->getAlt()); ?>"
                                            <?php if (!empty($lstImageSrcset)) : ?>
                                                data-srcset="<?php echo esc_attr($lstImageSrcset); ?>"
                                                data-sizes="auto"
                                            <?php else : ?>
                                                data-src="<?php echo esc_url($lstImage->getImageUrl('listivo_400_400')); ?>"
                                            <?php endif; ?>
                                        >

                                        <div class="listivo-review-gallery__zoom">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                                                 viewBox="0 0 35 35" fill="none">
                                                <path d="M16.6355 11C13.53 11 11 13.53 11 16.6355C11 19.741 13.53 22.271 16.6355 22.271C17.9788 22.271 19.2137 21.7964 20.1835 21.0079L23.9964 24.8208C24.0501 24.8767 24.1145 24.9214 24.1857 24.9522C24.2569 24.9829 24.3335 24.9992 24.411 25C24.4886 25.0008 24.5655 24.9861 24.6373 24.9567C24.7091 24.9274 24.7744 24.8841 24.8292 24.8292C24.8841 24.7744 24.9274 24.7091 24.9567 24.6373C24.9861 24.5655 25.0008 24.4886 25 24.411C24.9992 24.3335 24.9829 24.2569 24.9522 24.1857C24.9214 24.1145 24.8767 24.0501 24.8208 23.9964L21.0079 20.1835C21.7964 19.2137 22.271 17.9788 22.271 16.6355C22.271 13.53 19.741 11 16.6355 11ZM16.6355 12.166C19.1108 12.166 21.105 14.1601 21.105 16.6355C21.105 17.8413 20.6294 18.9308 19.8578 19.7333C19.8103 19.7683 19.7683 19.8103 19.7333 19.8578C18.9308 20.6294 17.8413 21.105 16.6355 21.105C14.1601 21.105 12.166 19.1108 12.166 16.6355C12.166 14.1601 14.1601 12.166 16.6355 12.166ZM16.6264 14.1009C16.4719 14.1033 16.3247 14.1669 16.2171 14.2778C16.1095 14.3887 16.0503 14.5377 16.0525 14.6922V16.0525H14.6922C14.615 16.0514 14.5383 16.0657 14.4666 16.0945C14.3949 16.1233 14.3296 16.1661 14.2746 16.2203C14.2196 16.2746 14.1759 16.3392 14.1461 16.4105C14.1163 16.4817 14.1009 16.5582 14.1009 16.6355C14.1009 16.7127 14.1163 16.7892 14.1461 16.8605C14.1759 16.9318 14.2196 16.9964 14.2746 17.0507C14.3296 17.1049 14.3949 17.1477 14.4666 17.1765C14.5383 17.2053 14.615 17.2196 14.6922 17.2185H16.0525V18.5788C16.0514 18.656 16.0657 18.7327 16.0945 18.8044C16.1233 18.8761 16.1661 18.9413 16.2203 18.9964C16.2746 19.0514 16.3392 19.0951 16.4105 19.1249C16.4817 19.1547 16.5582 19.17 16.6355 19.17C16.7127 19.17 16.7892 19.1547 16.8605 19.1249C16.9318 19.0951 16.9964 19.0514 17.0507 18.9964C17.1049 18.9413 17.1477 18.8761 17.1765 18.8044C17.2053 18.7327 17.2196 18.656 17.2185 18.5788V17.2185H18.5788C18.656 17.2196 18.7327 17.2053 18.8044 17.1765C18.8761 17.1477 18.9413 17.1049 18.9964 17.0507C19.0514 16.9964 19.0951 16.9318 19.1249 16.8605C19.1547 16.7892 19.17 16.7127 19.17 16.6355C19.17 16.5582 19.1547 16.4817 19.1249 16.4105C19.0951 16.3392 19.0514 16.2746 18.9964 16.2203C18.9413 16.1661 18.8761 16.1233 18.8044 16.0945C18.7327 16.0657 18.656 16.0514 18.5788 16.0525H17.2185V14.6922C17.2196 14.6142 17.205 14.5367 17.1757 14.4644C17.1463 14.3921 17.1027 14.3265 17.0475 14.2713C16.9923 14.2162 16.9266 14.1727 16.8542 14.1434C16.7819 14.1141 16.7044 14.0997 16.6264 14.1009Z"
                                                      fill="#374B5C"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </lst-review-gallery>
        <?php endif; ?>
    <?php endif; ?>

    <?php if (tdf_settings()->reviewsThumbsEnabled()) : ?>
        <lst-review-thumbs
                request-url="<?php echo esc_url(tdf_action_url('listivo/review/thumb')); ?>"
                td-nonce="<?php echo esc_attr(wp_create_nonce(tdf_prefix() . '/review/thumb')); ?>"
                :review-id="<?php echo esc_attr($lstReview->getId()); ?>"
                :initial-thumb="<?php echo esc_attr(GetInitialThumbStateAction::execute($lstReview)); ?>"
                :initial-thumb-up-count="<?php echo esc_attr($lstReview->getThumbUpCount()); ?>"
                :initial-thumb-down-count="<?php echo esc_attr($lstReview->getThumbDownCount()); ?>"
        >
            <div
                    class="listivo-review__thumbs"
                    slot-scope="thumbsProps"
            >
                <div
                        class="listivo-review-thumb listivo-review-thumb--up"
                        :class="{'listivo-review-thumb--active': thumbsProps.thumbUpActive}"
                        @click="thumbsProps.thumbUp"
                >
                    <div class="listivo-review-thumb__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                             viewBox="0 0 35 35"
                             fill="none">
                            <path d="M17.6141 9.625L17.4239 9.7962L13.2962 13.8859H10.5V23.625H20.7527C21.6111 23.625 22.3601 23.0187 22.5408 22.1793L23.8533 16.0924C24.0934 14.9677 23.2137 13.8859 22.0652 13.8859H18.5652L18.6793 13.4293C18.803 13.3342 18.8815 13.2938 19.0598 13.0489C19.3451 12.659 19.6304 12.055 19.6304 11.2418C19.6304 10.374 18.8458 9.625 17.8614 9.625H17.6141ZM18.0516 10.8995C18.3084 10.9494 18.413 11.054 18.413 11.2418C18.413 11.7911 18.2466 12.1311 18.0897 12.3451C17.9327 12.5591 17.8234 12.6114 17.8234 12.6114L17.6141 12.7255L17.538 12.9728L17.1766 14.3424L16.9864 15.1033H22.0652C22.4671 15.1033 22.7381 15.4528 22.6549 15.8451L21.3614 21.9321C21.2996 22.2174 21.0428 22.4076 20.7527 22.4076H14.1522V14.7418L18.0516 10.8995ZM11.7174 15.1033H12.9348V22.4076H11.7174V15.1033Z"
                            />
                        </svg>
                    </div>

                    <template>
                        <div class="listivo-review-thumb__count">
                            {{ thumbsProps.thumbUpCount }}
                        </div>
                    </template>
                </div>

                <div
                        class="listivo-review-thumb listivo-review-thumb--down"
                        :class="{'listivo-review-thumb--active': thumbsProps.thumbDownActive}"
                        @click="thumbsProps.thumbDown"
                >
                    <div class="listivo-review-thumb__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35"
                             viewBox="0 0 35 35"
                             fill="none">
                            <path d="M16.7765 25.375L16.9667 25.2038L21.0944 21.1141H23.8906V11.375L13.6379 11.375C12.7796 11.375 12.0306 11.9813 11.8499 12.8207L10.5374 18.9076C10.2972 20.0323 11.177 21.1141 12.3254 21.1141H15.8254L15.7113 21.5707C15.5876 21.6658 15.5092 21.7062 15.3308 21.9511C15.0455 22.341 14.7602 22.945 14.7602 23.7582C14.7602 24.626 15.5448 25.375 16.5292 25.375H16.7765ZM16.339 24.1005C16.0822 24.0506 15.9776 23.946 15.9776 23.7582C15.9776 23.2089 16.144 22.8689 16.301 22.6549C16.4579 22.4409 16.5673 22.3886 16.5673 22.3886L16.7765 22.2745L16.8526 22.0272L17.214 20.6576L17.4042 19.8967H12.3254C11.9236 19.8967 11.6525 19.5472 11.7357 19.1549L13.0292 13.0679C13.091 12.7826 13.3478 12.5924 13.6379 12.5924L20.2385 12.5924V20.2582L16.339 24.1005ZM22.6732 19.8967H21.4558V12.5924H22.6732V19.8967Z"
                            />
                        </svg>
                    </div>

                    <template>
                        <div class="listivo-review-thumb__count">
                            {{ thumbsProps.thumbDownCount }}
                        </div>
                    </template>
                </div>
            </div>
        </lst-review-thumbs>
    <?php endif; ?>
</div>