<?php
/* @var \Tangibledesign\Framework\Widgets\General\MenuWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstMenu = $lstCurrentWidget->getMenu();
?>
<div
    <?php if (tdf_settings()->showMenuAccount()) : ?>
        class="listivo-mobile-menu__wrapper listivo-hide-desktop"
    <?php else : ?>
        class="listivo-mobile-menu__wrapper listivo-mobile-menu__wrapper--mobile-simple-menu listivo-hide-desktop"
    <?php endif; ?>
>
    <?php if ($lstMenu) : ?>
        <div class="listivo-app listivo-mobile-menu__hamburger">
            <lst-mobile-menu prefix="listivo">
                <div slot-scope="menu">
                    <div class="listivo-menu-icon-wrapper" @click.prevent="menu.onShow">
                        <svg fill="#222" xmlns="http://www.w3.org/2000/svg" width="25" height="16" viewBox="0 0 25 16">
                            <g>
                                <g>
                                    <path d="M1.125 6.875H20.75a1.125 1.125 0 1 1 0 2.25H1.125a1.125 1.125 0 1 1 0-2.25zm.012 6.844h22.726c.628 0 1.137.509 1.137 1.137v.007C25 15.49 24.49 16 23.863 16H1.137C.51 16 0 15.49 0 14.863v-.007c0-.628.51-1.137 1.137-1.137zM1.137 0h16.476c.628 0 1.137.51 1.137 1.137v.007c0 .628-.51 1.137-1.137 1.137H1.137C.51 2.281 0 1.772 0 1.144v-.007C0 .51.51 0 1.137 0z"/>
                                </g>
                            </g>
                        </svg>
                    </div>

                    <template>
                        <div :class="{'listivo-active': menu.show}" class="listivo-mobile-menu__open">
                            <div class="listivo-mobile-menu__open__content">
                                <div class="listivo-mobile-menu__open__top">
                                    <?php if (tdf_settings()->showMenuCtaButton()) : ?>
                                        <div class="listivo-mobile-menu__open__top__submit-button">
                                            <a
                                                    href="<?php echo esc_url($lstCurrentWidget->getCtaButtonUrl()); ?>"
                                                    class="listivo-primary-button listivo-primary-button--icon"
                                            >
                                                <span class="listivo-primary-button__text">
                                                    <?php echo esc_html(tdf_string('add_listing')); ?>
                                                </span>

                                                <span class="listivo-primary-button__icon">
                                                    <?php if ($lstCurrentWidget->hasCtaButtonIcon()) : ?>
                                                        <i class="<?php echo esc_attr($lstCurrentWidget->getCtaButtonIcon()); ?>"></i>
                                                    <?php else : ?>
                                                        <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke="currentColor"
                                                        >
                                                            <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M12 4v16m8-8H4"
                                                            />
                                                        </svg>
                                                    <?php endif; ?>
                                                </span>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    <div class="listivo-mobile-menu__open__top__x">
                                        <svg @click="menu.onShow" xmlns="http://www.w3.org/2000/svg" width="21"
                                             height="19" viewBox="0 0 21 19">
                                            <g>
                                                <g>
                                                    <path fill="#fff"
                                                          d="M.602 18.781h2.443c.335 0 .574-.106.766-.284l6.178-6.615a.216.216 0 0 1 .336 0l6.13 6.615c.192.178.431.284.766.284h2.347c.48 0 .67-.284.383-.569L12.05 9.89a.176.176 0 0 1 0-.213l7.902-8.322c.288-.284.096-.569-.383-.569H17.03c-.336 0-.575.107-.767.285l-6.13 6.614a.215.215 0 0 1-.335 0l-6.13-6.614C3.475.893 3.235.786 2.9.786H.6c-.478 0-.67.285-.382.57l7.855 8.321a.177.177 0 0 1 0 .213L.219 18.212c-.288.285-.096.57.383.57z"/>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                </div>

                                <div class="listivo-mobile-menu__nav">
                                    <?php $lstMenu->display('listivo-menu-mobile', $lstCurrentWidget->getMenuArgs()); ?>
                                </div>

                                <?php if (!empty(tdf_settings()->getPhone()) || !empty(tdf_settings()->getMail())) : ?>
                                    <div class="listivo-mobile-menu__info">
                                        <?php if (!empty(tdf_settings()->getPhone())) : ?>
                                            <div class="listivo-mobile-menu__info-phone">
                                                <span class="listivo-mobile-menu__info-phone-label"><?php echo esc_html(tdf_string('call_support')); ?></span><span>:</span>
                                                <a href="tel:<?php echo esc_attr(tdf_settings()->getPhoneUrl()); ?>">
                                                    <?php echo esc_html(tdf_settings()->getPhone()); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <?php if (!empty(tdf_settings()->getMail())) : ?>
                                            <div class="listivo-mobile-menu__info-email">
                                                <span class="listivo-mobile-menu__info-email-label"><?php echo esc_html(tdf_string('email_address')); ?></span><span>:</span>
                                                <a href="mailto:<?php echo esc_attr(tdf_settings()->getMail()); ?>">
                                                    <?php echo esc_html(tdf_settings()->getMail()); ?>
                                                </a>
                                            </div>
                                        <?php endif; ?>

                                        <div class="listivo-mobile-menu__info-social">
                                            <?php if (!empty(tdf_settings()->getFacebookProfile()))  : ?>
                                                <a
                                                        class="listivo-social-profiles__single"
                                                        href="<?php echo esc_url(tdf_settings()->getFacebookProfile()); ?>"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path d="M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z"/>
                                                    </svg>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (!empty(tdf_settings()->getTwitterProfile()))  : ?>
                                                <a
                                                        class="listivo-social-profiles__single"
                                                        href="<?php echo esc_url(tdf_settings()->getTwitterProfile()); ?>"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"/>
                                                    </svg>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (!empty(tdf_settings()->getLinkedInProfile()))  : ?>
                                                <a
                                                        class="listivo-social-profiles__single"
                                                        href="<?php echo esc_url(tdf_settings()->getLinkedInProfile()); ?>"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z"/>
                                                    </svg>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (!empty(tdf_settings()->getInstagramProfile()))  : ?>
                                                <a
                                                        class="listivo-social-profiles__single"
                                                        href="<?php echo esc_url(tdf_settings()->getInstagramProfile()); ?>"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                                                    </svg>
                                                </a>
                                            <?php endif; ?>

                                            <?php if (!empty(tdf_settings()->getYouTubeProfile()))  : ?>
                                                <a
                                                        class="listivo-social-profiles__single"
                                                        href="<?php echo esc_url(tdf_settings()->getYouTubeProfile()); ?>"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                                        <!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                                        <path d="M549.7 124.1c-6.3-23.7-24.8-42.3-48.3-48.6C458.8 64 288 64 288 64S117.2 64 74.6 75.5c-23.5 6.3-42 24.9-48.3 48.6-11.4 42.9-11.4 132.3-11.4 132.3s0 89.4 11.4 132.3c6.3 23.7 24.8 41.5 48.3 47.8C117.2 448 288 448 288 448s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zm-317.5 213.5V175.2l142.7 81.2-142.7 81.2z"/>
                                                    </svg>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (tdf_currencies()->count() > 1) : ?>
                                    <lst-currency-switcher
                                            request-url="<?php echo esc_url(tdf_action_url('listivo/currency/switch')); ?>"
                                            :initial-currency-id="<?php echo esc_attr(tdf_current_currency()->getId()); ?>"
                                    >
                                        <div slot-scope="props" class="listivo-mobile-menu__currency-switcher">
                                            <?php echo esc_html(tdf_string('currency')); ?>

                                            <select
                                                    @change="props.setCurrency($event.target.value)"
                                                    :value="props.currencyId"
                                            >
                                                <?php foreach (tdf_currencies() as $listivoCurrency) :
                                                    /* @var \Tangibledesign\Framework\Models\Currency $listivoCurrency */
                                                    ?>
                                                    <option value="<?php echo esc_attr($listivoCurrency->getId()); ?>">
                                                        <?php echo esc_html($listivoCurrency->getName()); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>

                                            <i class="fas fa-angle-down listivo-text-primary"></i>
                                        </div>
                                    </lst-currency-switcher>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="listivo-mobile-menu-mask"></div>
                    </template>
                </div>
            </lst-mobile-menu>
        </div>
    <?php endif; ?>

    <div
        <?php if (!$lstMenu && tdf_settings()->showMenuAccount()) : ?>
            class="listivo-mobile-menu__logo listivo-mobile-menu__logo--left"
        <?php elseif (tdf_settings()->showMenuAccount()) : ?>
            class="listivo-mobile-menu__logo"
        <?php else : ?>
            class="listivo-mobile-menu__logo listivo-mobile-menu__logo--right"
        <?php endif; ?>
    >
        <?php if ($lstCurrentWidget->hasLogo()) : ?>
            <div class="listivo-logo">
                <a
                        href="<?php echo esc_url(get_site_url()); ?>"
                        title="<?php echo esc_attr(get_bloginfo('name')); ?>"
                >
                    <img
                            src="<?php echo esc_url($lstCurrentWidget->getLogo()->getImageUrl()); ?>"
                            alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                    >
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if (tdf_settings()->showMenuAccount()) : ?>
        <div class="listivo-mobile-menu__login">
            <a class="listivo-user-icon-wrapper" href="<?php echo esc_url(tdf_settings()->getPanelPageUrl()); ?>">
                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="m437.019531 74.980469c-48.351562-48.351563-112.640625-74.980469-181.019531-74.980469s-132.667969 26.628906-181.019531 74.980469c-48.351563 48.351562-74.980469 112.640625-74.980469 181.019531s26.628906 132.667969 74.980469 181.019531c48.351562 48.351563 112.640625 74.980469 181.019531 74.980469s132.667969-26.628906 181.019531-74.980469c48.351563-48.351562 74.980469-112.640625 74.980469-181.019531s-26.628906-132.667969-74.980469-181.019531zm-325.914062 354.316406c8.453125-72.734375 70.988281-128.890625 144.894531-128.890625 38.960938 0 75.597656 15.179688 103.15625 42.734375 23.28125 23.285156 37.964844 53.6875 41.742188 86.152344-39.257813 32.878906-89.804688 52.707031-144.898438 52.707031s-105.636719-19.824219-144.894531-52.703125zm144.894531-159.789063c-42.871094 0-77.753906-34.882812-77.753906-77.753906 0-42.875 34.882812-77.753906 77.753906-77.753906s77.753906 34.878906 77.753906 77.753906c0 42.871094-34.882812 77.753906-77.753906 77.753906zm170.71875 134.425782c-7.644531-30.820313-23.585938-59.238282-46.351562-82.003906-18.4375-18.4375-40.25-32.269532-64.039063-40.9375 28.597656-19.394532 47.425781-52.160157 47.425781-89.238282 0-59.414062-48.339844-107.753906-107.753906-107.753906s-107.753906 48.339844-107.753906 107.753906c0 37.097656 18.84375 69.875 47.464844 89.265625-21.886719 7.976563-42.140626 20.308594-59.566407 36.542969-25.234375 23.5-42.757812 53.464844-50.882812 86.347656-34.410157-39.667968-55.261719-91.398437-55.261719-147.910156 0-124.617188 101.382812-226 226-226s226 101.382812 226 226c0 56.523438-20.859375 108.265625-55.28125 147.933594zm0 0"/>
                </svg>
            </a>
        </div>
    <?php endif; ?>
</div>
