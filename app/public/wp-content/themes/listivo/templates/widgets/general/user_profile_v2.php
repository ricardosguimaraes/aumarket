<?php

use Tangibledesign\Framework\Core\Image\RenderUserImage;
use Tangibledesign\Listivo\Widgets\General\UserProfileV2Widget;

/* @var UserProfileV2Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = $lstCurrentWidget->getUser();
if (!$lstUser) {
    return;
}

$lstUserImage = $lstUser->getImage();
?>
<div class="listivo-user-profile">
    <?php if ($lstCurrentWidget->decorationEnabled()) : ?>
        <div class="listivo-user-profile__circle listivo-user-profile__circle--1"></div>

        <div class="listivo-user-profile__circle listivo-user-profile__circle--2"></div>

        <div class="listivo-user-profile__circle listivo-user-profile__circle--small listivo-user-profile__circle--3"></div>

        <div class="listivo-user-profile__circle listivo-user-profile__circle--small listivo-user-profile__circle--4"></div>

        <div class="listivo-user-profile__x listivo-user-profile__x--1">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" fill="none">
                <path d="M13.7572 35.3434L9.63333 31.2196L31.2199 9.63304L35.3437 13.7569L13.7572 35.3434ZM9.0733 13.2478L13.299 9.02209L35.9547 31.6778L31.729 35.9035L9.0733 13.2478Z"
                      fill="#E6F0FA"/>
            </svg>
        </div>

        <div class="listivo-user-profile__x listivo-user-profile__x--2">
            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" viewBox="0 0 45 45" fill="none">
                <path d="M13.7572 35.3434L9.63333 31.2196L31.2199 9.63304L35.3437 13.7569L13.7572 35.3434ZM9.0733 13.2478L13.299 9.02209L35.9547 31.6778L31.729 35.9035L9.0733 13.2478Z"
                      fill="#E6F0FA"/>
            </svg>
        </div>
    <?php endif; ?>

    <div class="listivo-user-profile__left">
        <div class="listivo-user-profile__image">
            <a class="listivo-user-profile__link" href="<?php echo esc_url($lstUser->getUrl()); ?>"></a>

            <?php RenderUserImage::render($lstUser, 'full'); ?>

            <div class="listivo-user-profile__socials">
                <div class="listivo-social-icons listivo-social-icons--center">
                    <?php if (!empty($lstUser->getFacebookProfile()))  : ?>
                        <a
                                class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--v2"
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
                                class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--v2"
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
                                class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--v2"
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
                                class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--v2"
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
                                class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--v2"
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
                                class="listivo-social-icons__icon listivo-social-icon listivo-social-icon--v2"
                                href="<?php echo esc_url($lstUser->getTiktokProfile()); ?>"
                                target="_blank"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path d="M448 209.9a210.1 210.1 0 0 1 -122.8-39.3V349.4A162.6 162.6 0 1 1 185 188.3V278.2a74.6 74.6 0 1 0 52.2 71.2V0l88 0a121.2 121.2 0 0 0 1.9 22.2h0A122.2 122.2 0 0 0 381 102.4a121.4 121.4 0 0 0 67 20.1z"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="listivo-user-profile__content">
        <div class="listivo-user-profile__head">
            <div class="listivo-user-profile__name">
                <?php echo esc_html($lstUser->getDisplayName()); ?>
            </div>

            <?php if (!empty($lstUser->getJobTitle())) : ?>
                <div class="listivo-user-profile__job-title">
                    <?php echo esc_html($lstUser->getJobTitle()); ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($lstUser->getDescription())) : ?>
            <div class="listivo-user-profile__description">
                <?php echo wp_kses_post($lstUser->getDescription()); ?>
            </div>
        <?php endif; ?>

        <div class="listivo-user-profile__buttons">
            <?php if (!empty($lstUser->getPhone())) : ?>
                <a
                        class="listivo-user-profile__button listivo-contact-button"
                        href="tel:<?php echo esc_attr($lstUser->getPhoneUrl()); ?>"
                >
                    <div class="listivo-contact-button__inner">
                        <div class="listivo-contact-button__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24" viewBox="0 0 14 24"
                                 fill="none">
                                <path d="M2.625 0C1.18562 0 0 1.18562 0 2.625V20.7083C0 22.1477 1.18562 23.3333 2.625 23.3333H11.375C12.8144 23.3333 14 22.1477 14 20.7083V2.625C14 1.18562 12.8144 0 11.375 0H2.625ZM2.625 1.75H11.375C11.8688 1.75 12.25 2.13121 12.25 2.625V20.7083C12.25 21.2021 11.8688 21.5833 11.375 21.5833H2.625C2.13121 21.5833 1.75 21.2021 1.75 20.7083V2.625C1.75 2.13121 2.13121 1.75 2.625 1.75ZM7 3.5C6.76794 3.5 6.54538 3.59219 6.38128 3.75628C6.21719 3.92038 6.125 4.14294 6.125 4.375C6.125 4.60706 6.21719 4.82962 6.38128 4.99372C6.54538 5.15781 6.76794 5.25 7 5.25C7.23206 5.25 7.45462 5.15781 7.61872 4.99372C7.78281 4.82962 7.875 4.60706 7.875 4.375C7.875 4.14294 7.78281 3.92038 7.61872 3.75628C7.45462 3.59219 7.23206 3.5 7 3.5ZM5.54167 18.0833C5.42572 18.0817 5.3106 18.1031 5.203 18.1464C5.09541 18.1896 4.99748 18.2538 4.9149 18.3352C4.83233 18.4166 4.76676 18.5136 4.722 18.6206C4.67725 18.7276 4.6542 18.8424 4.6542 18.9583C4.6542 19.0743 4.67725 19.1891 4.722 19.2961C4.76676 19.403 4.83233 19.5001 4.9149 19.5815C4.99748 19.6629 5.09541 19.7271 5.203 19.7703C5.3106 19.8136 5.42572 19.835 5.54167 19.8333H8.45833C8.57428 19.835 8.6894 19.8136 8.797 19.7703C8.90459 19.7271 9.00252 19.6629 9.0851 19.5815C9.16767 19.5001 9.23324 19.403 9.278 19.2961C9.32275 19.1891 9.3458 19.0743 9.3458 18.9583C9.3458 18.8424 9.32275 18.7276 9.278 18.6206C9.23324 18.5136 9.16767 18.4166 9.0851 18.3352C9.00252 18.2538 8.90459 18.1896 8.797 18.1464C8.6894 18.1031 8.57428 18.0817 8.45833 18.0833H5.54167Z"
                                      fill="#2A3946"/>
                            </svg>
                        </div>

                        <?php echo esc_html($lstUser->getPhone()); ?>
                    </div>
                </a>
            <?php endif; ?>

            <a
                    class="listivo-user-profile__button listivo-contact-button"
                    href="mailto:<?php echo esc_attr($lstUser->getMail()); ?>"
            >
                <div class="listivo-contact-button__inner">
                    <div class="listivo-contact-button__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M0 10C0 4.48604 4.48603 0 10 0C15.514 0 20 4.48604 20 10C20 15.514 15.514 20 10 20C4.48603 20 0 15.514 0 10ZM18.5 10C18.5 5.2967 14.7033 1.5 10 1.5C5.29669 1.5 1.5 5.2967 1.5 10C1.5 14.7033 5.29669 18.5 10 18.5C14.7033 18.5 18.5 14.7033 18.5 10ZM10 3C6.14273 3 3 6.14273 3 10C3 13.8573 6.14273 17 10 17C10.8636 17 11.6941 16.8433 12.46 16.5557C12.7139 16.4637 12.8988 16.2423 12.944 15.9761C12.9892 15.7098 12.8878 15.4398 12.6785 15.2691C12.4692 15.0984 12.1843 15.0535 11.9326 15.1514C11.3324 15.3768 10.6824 15.5 10 15.5C6.95327 15.5 4.5 13.0467 4.5 10C4.5 6.95327 6.95327 4.5 10 4.5C13.0467 4.5 15.5 6.95327 15.5 10V10.75C15.5 11.4491 14.9491 12 14.25 12C13.5509 12 13 11.4491 13 10.75V7.25C13.003 6.86865 12.7194 6.54574 12.3409 6.49952C11.9623 6.45329 11.6093 6.69847 11.5205 7.06934C11.0143 6.71213 10.4088 6.5 9.75 6.5C7.92409 6.5 6.5 8.11373 6.5 10C6.5 11.8863 7.92409 13.5 9.75 13.5C10.6754 13.5 11.4961 13.0841 12.082 12.4297C12.5868 13.078 13.3716 13.5 14.25 13.5C15.7599 13.5 17 12.2599 17 10.75V10C17 6.14273 13.8573 3 10 3ZM11.5 10C11.5 8.85327 10.6811 8 9.75 8C8.81891 8 8 8.85327 8 10C8 11.1467 8.81891 12 9.75 12C10.6811 12 11.5 11.1467 11.5 10Z"
                                  fill="#2A3946"/>
                        </svg>
                    </div>

                    <?php echo esc_html($lstUser->getMail()); ?>
                </div>
            </a>
        </div>
    </div>
</div>

