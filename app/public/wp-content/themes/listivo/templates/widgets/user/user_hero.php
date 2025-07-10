<?php

use Tangibledesign\Framework\Core\Image\RenderUserImage;
use Tangibledesign\Listivo\Widgets\User\UserHeroWidget;

/* @var UserHeroWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}
?>
<div
    <?php if ($lstCurrentWidget->isFullWidth()) : ?>
        class="listivo-user-hero listivo-user-hero--full-width"
    <?php else : ?>
        class="listivo-user-hero"
    <?php endif; ?>
>
    <?php if ($lstCurrentWidget->decorationEnabled()) : ?>
        <div class="listivo-user-hero__decoration-container">
            <div class="listivo-user-hero__circle listivo-user-hero__circle--1"></div>

            <div class="listivo-user-hero__circle listivo-user-hero__circle--2"></div>

            <div class="listivo-user-hero__small-circle listivo-user-hero__small-circle--1"></div>

            <div class="listivo-user-hero__small-circle listivo-user-hero__small-circle--2"></div>

            <div class="listivo-user-hero__x listivo-user-hero__x--1">
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" fill="none">
                    <path d="M13.7572 35.3434L9.63333 31.2196L31.2199 9.63304L35.3437 13.7569L13.7572 35.3434ZM9.0733 13.2478L13.299 9.02209L35.9547 31.6778L31.729 35.9035L9.0733 13.2478Z"
                          fill="#E6F0FA"/>
                </svg>
            </div>

            <div class="listivo-user-hero__x listivo-user-hero__x--2">
                <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" fill="none">
                    <path d="M13.7572 35.3434L9.63333 31.2196L31.2199 9.63304L35.3437 13.7569L13.7572 35.3434ZM9.0733 13.2478L13.299 9.02209L35.9547 31.6778L31.729 35.9035L9.0733 13.2478Z"
                          fill="#E6F0FA"/>
                </svg>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($lstCurrentWidget->getBackgroundImage())) : ?>
        <div class="listivo-user-hero__top">
            <div class="listivo-user-hero__background">
                <img
                        class="lazyload"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                        data-src="<?php echo esc_url($lstCurrentWidget->getBackgroundImage()); ?>"
                        alt=""
                >
            </div>
        </div>
    <?php endif; ?>

    <div class="listivo-user-hero__content-wrapper">
        <div
            <?php if (empty($lstCurrentWidget->getBackgroundImage())) : ?>
                class="listivo-user-hero__content listivo-user-hero__content--no-background"
            <?php else : ?>
                class="listivo-user-hero__content"
            <?php endif; ?>
        >
            <div class="listivo-user-hero__avatar">
                <?php RenderUserImage::render($lstUser, 'listivo_400_400', RenderUserImage::PLACEHOLDER_CIRCLE); ?>
            </div>

            <h1 class="listivo-user-hero__name">
                <?php echo esc_html($lstUser->getDisplayName()); ?>
            </h1>

            <?php if ($lstCurrentWidget->showMemberSince() || (!empty($lstUser->getAddress()) && $lstCurrentWidget->showAddress())) : ?>
                <div class="listivo-user-hero__meta">
                    <?php if ($lstCurrentWidget->showMemberSince()) : ?>
                        <div class="listivo-user-hero__data">
                            <div class="listivo-user-hero__data-icon-wrapper">
                                <div class="listivo-user-hero__data-icon listivo-small-icon listivo-small-icon--circle listivo-small-icon--primary-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="11" viewBox="0 0 10 11"
                                         fill="none">
                                        <path d="M5 0C3.07227 0 1.5 1.57227 1.5 3.5C1.5 4.70508 2.11523 5.77539 3.04688 6.40625C1.26367 7.17188 0 8.94141 0 11H1C1 9.55469 1.76367 8.29688 2.90625 7.59375C3.24219 8.41797 4.06055 9 5 9C5.93945 9 6.75781 8.41797 7.09375 7.59375C8.23633 8.29688 9 9.55469 9 11H10C10 8.94141 8.73633 7.17188 6.95312 6.40625C7.88477 5.77539 8.5 4.70508 8.5 3.5C8.5 1.57227 6.92773 0 5 0ZM5 1C6.38672 1 7.5 2.11328 7.5 3.5C7.5 4.88672 6.38672 6 5 6C3.61328 6 2.5 4.88672 2.5 3.5C2.5 2.11328 3.61328 1 5 1ZM5 7C5.41016 7 5.80078 7.05859 6.17188 7.17188C5.99805 7.6543 5.54492 8 5 8C4.45508 8 4.00195 7.6543 3.82812 7.17188C4.19922 7.05859 4.58984 7 5 7Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="listivo-user-hero__data-text">
                                <?php echo esc_html(tdf_string('member_since') . ' ' . $lstUser->getRegistrationDateDiff()); ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($lstUser->getAddress()) && $lstCurrentWidget->showAddress()) : ?>
                        <div class="listivo-user-hero__data">
                            <div class="listivo-user-hero__data-icon-wrapper">
                                <div class="listivo-user-hero__data-icon listivo-small-icon listivo-small-icon--circle listivo-small-icon--primary-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14"
                                         fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M5 0C2.24609 0 0 2.27981 0 5.07505C0 5.8601 0.316406 6.72048 0.753906 7.62843C1.19141 8.54036 1.76172 9.49193 2.33594 10.3602C3.47656 12.1008 4.61328 13.5163 4.61328 13.5163L5 14L5.38672 13.5163C5.38672 13.5163 6.52344 12.1008 7.66797 10.3602C8.23828 9.49193 8.80859 8.54036 9.24609 7.62843C9.68359 6.72048 10 5.8601 10 5.07505C10 2.27981 7.75391 0 5 0ZM5 1.01514C7.21484 1.01514 9 2.82709 9 5.07518C9 5.55096 8.75391 6.33997 8.34766 7.18449C7.94141 8.03298 7.38672 8.95283 6.83594 9.80132C5.99563 11.0789 5.40082 11.8315 5.08146 12.2356L5 12.3388L4.91854 12.2356C4.59919 11.8315 4.00437 11.0789 3.16406 9.80132C2.61328 8.95283 2.05859 8.03298 1.65234 7.18449C1.24609 6.33997 1 5.55096 1 5.07518C1 2.82709 2.78516 1.01514 5 1.01514ZM4.00002 5.06006C4.00002 4.50928 4.44924 4.06006 5.00002 4.06006C5.5508 4.06006 6.00002 4.50928 6.00002 5.06006C6.00002 5.61084 5.5508 6.06006 5.00002 6.06006C4.44924 6.06006 4.00002 5.61084 4.00002 5.06006Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </div>
                            </div>

                            <div class="listivo-user-hero__data-text">
                                <?php echo esc_html($lstUser->getAddress()); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($lstCurrentWidget->showSocial()) : ?>
                <div class="listivo-user-hero__socials">
                    <div class="listivo-social-icons-wrapper">
                        <div class="listivo-social-icons">
                            <?php if (!empty($lstUser->getFacebookProfile()))  : ?>
                                <a
                                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                        href="<?php echo esc_url($lstUser->getFacebookProfile()); ?>"
                                        target="_blank"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($lstUser->getTwitterProfile()))  : ?>
                                <a
                                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                        href="<?php echo esc_url($lstUser->getTwitterProfile()); ?>"
                                        target="_blank"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($lstUser->getLinkedInProfile()))  : ?>
                                <a
                                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                        href="<?php echo esc_url($lstUser->getLinkedInProfile()); ?>"
                                        target="_blank"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($lstUser->getInstagramProfile()))  : ?>
                                <a
                                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                        href="<?php echo esc_url($lstUser->getInstagramProfile()); ?>"
                                        target="_blank"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($lstUser->getYouTubeProfile()))  : ?>
                                <a
                                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                        href="<?php echo esc_url($lstUser->getYouTubeProfile()); ?>"
                                        target="_blank"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($lstUser->getTiktokProfile())) : ?>
                                <a
                                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                        href="<?php echo esc_url($lstUser->getTiktokProfile()); ?>"
                                        target="_blank"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($lstUser->getTelegramProfile())) : ?>
                                <a
                                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                        href="<?php echo esc_url($lstUser->getTelegramProfile()); ?>"
                                        target="_blank"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if (!empty($lstUser->getEbayProfile())) : ?>
                                <a
                                        class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                        href="<?php echo esc_url($lstUser->getEbayProfile()); ?>"
                                        target="_blank"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                        <!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                        <path d="M606 189.5l-54.8 109.9-54.9-109.9h-37.5l10.9 20.6c-11.5-19-35.9-26-63.3-26-31.8 0-67.9 8.7-71.5 43.1h33.7c1.4-13.8 15.7-21.8 35-21.8 26 0 41 9.6 41 33v3.4c-12.7 0-28 .1-41.7 .4-42.4 .9-69.6 10-76.7 34.4 1-5.2 1.5-10.6 1.5-16.2 0-52.1-39.7-76.2-75.4-76.2-21.3 0-43 5.5-58.7 24.2v-80.6h-32.1v169.5c0 10.3-.6 22.9-1.1 33.1h31.5c.7-6.3 1.1-12.9 1.1-19.5 13.6 16.6 35.4 24.9 58.7 24.9 36.9 0 64.9-21.9 73.3-54.2-.5 2.8-.7 5.8-.7 9 0 24.1 21.1 45 60.6 45 26.6 0 45.8-5.7 61.9-25.5 0 6.6 .3 13.3 1.1 20.2h29.8c-.7-8.2-1-17.5-1-26.8v-65.6c0-9.3-1.7-17.2-4.8-23.8l61.5 116.1-28.5 54.1h35.9L640 189.5zM243.7 313.8c-29.6 0-50.2-21.5-50.2-53.8 0-32.4 20.6-53.8 50.2-53.8 29.8 0 50.2 21.4 50.2 53.8 0 32.3-20.4 53.8-50.2 53.8zm200.9-47.3c0 30-17.9 48.4-51.6 48.4-25.1 0-35-13.4-35-25.8 0-19.1 18.1-24.4 47.2-25.3 13.1-.5 27.6-.6 39.4-.6zm-411.9 1.6h128.8v-8.5c0-51.7-33.1-75.4-78.4-75.4-56.8 0-83 30.8-83 77.6 0 42.5 25.3 74 82.5 74 31.4 0 68-11.7 74.4-46.1h-33.1c-12 35.8-87.7 36.7-91.2-21.6zm95-21.4H33.3c6.9-56.6 92.1-54.7 94.4 0z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>