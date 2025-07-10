<?php

use Tangibledesign\Framework\Core\Image\RenderUserImage;
use Tangibledesign\Listivo\Widgets\General\UserProfilesWidget;

/* @var UserProfilesWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUsers = $lstCurrentWidget->getUsers();
if ($lstUsers->isEmpty()) {
    return;
}
?>
<div class="listivo-user-profiles">
    <?php foreach ($lstUsers as $lstUser) :
        ?>
        <div
            <?php if ($lstCurrentWidget->smallerIcons()) : ?>
                class="listivo-single-user-profile listivo-single-user-profile--icons-smaller"
            <?php else : ?>
                class="listivo-single-user-profile"
            <?php endif; ?>
        >
            <a class="listivo-single-user-profile__link" href="<?php echo esc_url($lstUser->getUrl()); ?>"></a>

            <div class="listivo-single-user-profile__image">
                <?php RenderUserImage::render($lstUser, 'listivo_400_400'); ?>
            </div>

            <div class="listivo-single-user-profile__content">
                <a href="<?php echo esc_url($lstUser->getUrl()); ?>">
                    <h3 class="listivo-single-user-profile__label">
                        <?php echo esc_html($lstUser->getDisplayName()); ?>
                    </h3>
                </a>

                <?php if (!empty($lstUser->getJobTitle())) : ?>
                    <div class="listivo-single-user-profile__job-title">
                        <?php echo esc_html($lstUser->getJobTitle()); ?>
                    </div>
                <?php endif; ?>

                <div class="listivo-single-user-profile__socials">
                    <div class="listivo-social-icons">
                        <?php if (!empty($lstUser->getFacebookProfile()))  : ?>
                            <a
                                <?php if ($lstCurrentWidget->smallerIcons()) : ?>
                                    class="listivo-social-icon listivo-social-icon--smaller listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php else : ?>
                                    class="listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php endif; ?>
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
                                <?php if ($lstCurrentWidget->smallerIcons()) : ?>
                                    class="listivo-social-icon listivo-social-icon--smaller listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php else : ?>
                                    class="listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php endif; ?>
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
                                <?php if ($lstCurrentWidget->smallerIcons()) : ?>
                                    class="listivo-social-icon listivo-social-icon--smaller listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php else : ?>
                                    class="listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php endif; ?>
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
                                <?php if ($lstCurrentWidget->smallerIcons()) : ?>
                                    class="listivo-social-icon listivo-social-icon--smaller listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php else : ?>
                                    class="listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php endif; ?>
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
                                <?php if ($lstCurrentWidget->smallerIcons()) : ?>
                                    class="listivo-social-icon listivo-social-icon--smaller listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php else : ?>
                                    class="listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php endif; ?>
                                    href="<?php echo esc_url($lstUser->getYouTubeProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($lstUser->getTiktokProfile()))  : ?>
                            <a
                                <?php if ($lstCurrentWidget->smallerIcons()) : ?>
                                    class="listivo-social-icon listivo-social-icon--smaller listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php else : ?>
                                    class="listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php endif; ?>
                                    href="<?php echo esc_url($lstUser->getTiktokProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($lstUser->getTelegramProfile()))  : ?>
                            <a
                                <?php if ($lstCurrentWidget->smallerIcons()) : ?>
                                    class="listivo-social-icon listivo-social-icon--smaller listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php else : ?>
                                    class="listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php endif; ?>
                                    href="<?php echo esc_url($lstUser->getTelegramProfile()); ?>"
                                    target="_blank"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 496 512">
                                    <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                    <path d="M248 8C111 8 0 119 0 256S111 504 248 504 496 393 496 256 385 8 248 8zM363 176.7c-3.7 39.2-19.9 134.4-28.1 178.3-3.5 18.6-10.3 24.8-16.9 25.4-14.4 1.3-25.3-9.5-39.3-18.7-21.8-14.3-34.2-23.2-55.3-37.2-24.5-16.1-8.6-25 5.3-39.5 3.7-3.8 67.1-61.5 68.3-66.7 .2-.7 .3-3.1-1.2-4.4s-3.6-.8-5.1-.5q-3.3 .7-104.6 69.1-14.8 10.2-26.9 9.9c-8.9-.2-25.9-5-38.6-9.1-15.5-5-27.9-7.7-26.8-16.3q.8-6.7 18.5-13.7 108.4-47.2 144.6-62.3c68.9-28.6 83.2-33.6 92.5-33.8 2.1 0 6.6 .5 9.6 2.9a10.5 10.5 0 0 1 3.5 6.7A43.8 43.8 0 0 1 363 176.7z"/>
                                </svg>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($lstUser->getEbayProfile()))  : ?>
                            <a
                                <?php if ($lstCurrentWidget->smallerIcons()) : ?>
                                    class="listivo-social-icon listivo-social-icon--smaller listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php else : ?>
                                    class="listivo-social-icon listivo-social-icon--color-1 listivo-social-icon--hover-color-primary"
                                <?php endif; ?>
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
        </div>
    <?php endforeach; ?>
</div>