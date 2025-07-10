<?php

use Tangibledesign\Framework\Widgets\General\PanelWidget;
use Tangibledesign\Listivo\Widgets\General\MenuWidget;

/* @var MenuWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstMenu = $lstCurrentWidget->getMenu();
?>
<div class="listivo-menu__desktop">
    <div class="listivo-menu__wrapper">
        <div class="listivo-menu__limit-width">
            <div class="listivo-menu__left">
                <?php if ($lstCurrentWidget->hasLogo()) : ?>
                    <div class="listivo-logo">
                        <a
                                href="<?php echo esc_url(get_site_url()); ?>"
                                title="<?php echo esc_attr(get_bloginfo('name')); ?>"
                        >
                            <img
                                    src="<?php echo esc_url($lstCurrentWidget->getLogoUrl()); ?>"
                                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                            >
                        </a>
                    </div>

                    <div class="listivo-logo listivo-logo--sticky">
                        <a
                                href="<?php echo esc_url(get_site_url()); ?>"
                                title="<?php echo esc_attr(get_bloginfo('name')); ?>"
                        >
                            <img
                                    src="<?php echo esc_url($lstCurrentWidget->getStickyLogoUrl()); ?>"
                                    alt="<?php echo esc_attr(get_bloginfo('name')); ?>"
                            >
                        </a>
                    </div>
                <?php endif; ?>

                <?php if ($lstMenu) : ?>
                    <div class="listivo-menu__container">
                        <div class="listivo-menu-hover"></div>

                        <?php $lstMenu->display('', $lstCurrentWidget->getMenuArgs()); ?>
                    </div>
                <?php endif; ?>
            </div>

            <div class="listivo-menu__more listivo-app">
                <?php if (tdf_currencies()->count() > 1) : ?>
                    <lst-currency-switcher
                            request-url="<?php echo esc_url(tdf_action_url('listivo/currency/switch')); ?>"
                            :initial-currency-id="<?php echo esc_attr(tdf_current_currency()->getId()); ?>"
                            class="listivo-menu-desktop-login-register-link"
                    >
                        <div slot-scope="props">
                            <div class="listivo-menu-item-depth-0">
                                <a href="#" class="listivo-menu-desktop--link">
                                    <?php echo esc_html(tdf_current_currency()->getName()); ?>
                                </a>
                            </div>

                            <div class="listivo-desktop-user-menu listivo-desktop-user-menu--currency listivo-submenu listivo-submenu--level-0">
                                <div class="listivo-desktop-user-menu__inner">
                                    <div class="listivo-desktop-user-menu__menu-links">
                                        <?php foreach (tdf_currencies() as $listivoCurrency) : ?>
                                            <div
                                                <?php if ($listivoCurrency->getId() === tdf_current_currency()->getId()) : ?>
                                                    class="listivo-desktop-user-menu__menu-link listivo-desktop-user-menu__menu-link--currency-active"
                                                <?php else : ?>
                                                    class="listivo-desktop-user-menu__menu-link"
                                                <?php endif; ?>
                                                    @click.prevent="props.setCurrency('<?php echo esc_attr($listivoCurrency->getId()); ?>')"
                                            >
                                                <i class="far fa-circle"></i>
                                                <i class="fas fa-dot-circle"></i>

                                                <?php echo esc_html($listivoCurrency->getName()); ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </lst-currency-switcher>
                <?php endif; ?>

                <?php if (tdf_settings()->showMenuAccount()) : ?>
                    <div class="listivo-menu-desktop-login-register-link">
                        <?php if (is_user_logged_in()) :
                            $lstCurrentUser = tdf_current_user();
                            ?>
                            <div class="listivo-menu-item-depth-0">
                                <a class="listivo-menu-desktop-dashboard-link"
                                   href="<?php echo esc_url(tdf_settings()->getPanelPageUrl()); ?>"
                                >
                                    <svg class="listivo-menu-user-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                              d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>

                                    <?php echo esc_html(tdf_string('dashboard')); ?>
                                </a>
                            </div>

                            <div class="listivo-desktop-user-menu listivo-submenu listivo-submenu--level-0">
                                <div class="listivo-desktop-user-menu__inner">
                                    <div class="listivo-desktop-user-menu__top">
                                        <div class="listivo-desktop-user-menu__top-inner">
                                            <?php if ($lstCurrentUser->hasImageUrl()) : ?>
                                                <div class="listivo-desktop-user-menu__top-avatar">
                                                    <img src="<?php echo esc_url($lstCurrentUser->getImageUrl()); ?>">
                                                </div>
                                            <?php else : ?>
                                                <?php get_template_part('templates/partials/avatar'); ?>
                                            <?php endif; ?>

                                            <div class="listivo-desktop-user-menu__top-info">
                                                <div class="listivo-desktop-user-menu__name">
                                                    <a href="<?php echo esc_url($lstCurrentUser->getUrl()); ?>">
                                                        <?php echo esc_html($lstCurrentUser->getDisplayName()); ?>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="listivo-desktop-user-menu__menu-links">
                                        <a class="listivo-desktop-user-menu__menu-link--add-listing"
                                           href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_CREATE)); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>

                                            <?php echo esc_html(tdf_string('add_listing')); ?>
                                        </a>

                                        <?php if (tdf_current_user()->isModerator()) : ?>
                                            <a class="listivo-desktop-user-menu__menu-link--moderation"
                                               href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MODERATION)); ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                </svg>

                                                <?php echo esc_html(tdf_string('moderation')); ?>

                                                <span class="listivo-desktop-user-menu__menu-links__count-pending">
                                                    <?php echo esc_html(wp_count_posts(tdf_model_post_type())->pending); ?>
                                                </span>
                                            </a>
                                        <?php endif; ?>

                                        <a class="listivo-desktop-user-menu__menu-link--my-listings"
                                           href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_LIST)); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                            </svg>

                                            <?php echo esc_html(tdf_string('my_listings')); ?>

                                            <?php if (!empty(tdf_current_user()->getCurrentUserPublishModelNumber())) : ?>
                                                <span class="listivo-desktop-user-menu__menu-links__count-listings">
                                                    <?php echo esc_html(tdf_current_user()->getCurrentUserPublishModelNumber()); ?>
                                                </span>
                                            <?php endif; ?>
                                        </a>

                                        <?php if (tdf_settings()->messageSystem()) : ?>
                                            <a class="listivo-desktop-user-menu__menu-link--messages"
                                               href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MESSAGES)); ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                                </svg>

                                                <?php echo esc_html(tdf_string('messages')); ?>

                                                <?php if (!empty(tdf_current_user()->getNotSeenConversationNumber())) : ?>
                                                    <span class="listivo-desktop-user-menu__menu-links__count-msg">
                                                        <?php echo esc_html(tdf_current_user()->getNotSeenConversationNumber()); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </a>
                                        <?php endif; ?>

                                        <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
                                            <a class="listivo-desktop-user-menu__menu-link--favorites"
                                               href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_FAVORITES)); ?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                                </svg>

                                                <?php echo esc_html(tdf_string('favorites')); ?>

                                                <span class="listivo-desktop-user-menu__menu-links__count-fav">
                                                    <?php echo esc_html(tdf_current_user()->getFavoriteNumber()); ?>
                                                </span>
                                            </a>
                                        <?php endif; ?>

                                        <a class="listivo-desktop-user-menu__menu-link--settings"
                                           href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_SETTINGS)); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                                            </svg>

                                            <?php echo esc_html(tdf_string('settings')); ?>
                                        </a>

                                        <hr>

                                        <a class="listivo-desktop-user-menu__menu-link--logout"
                                           href="<?php echo esc_url(tdf_logout_url()); ?>">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                            </svg>

                                            <?php echo esc_html(tdf_string('log_out')); ?>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        <?php else : ?>
                            <?php if (!empty(tdf_settings()->getLoginPageUrl())) : ?>
                                <svg class="listivo-menu-user-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                          d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>

                                <div class="listivo-menu-item-depth-0">
                                    <a href="<?php echo esc_url(tdf_settings()->getLoginPageUrl()); ?>">
                                        <span class="listivo-menu-desktop-login-register-link__login-text listivo-menu-item-depth-0">
                                            <?php echo esc_html(tdf_string('log_in')); ?>
                                        </span>
                                    </a>
                                </div>

                                <?php if (tdf_settings()->userRegistrationOpen()) : ?>
                                    <span class="listivo-menu-desktop-login-register-link__separator"></span>

                                    <div class="listivo-menu-item-depth-0">
                                        <a href="<?php echo esc_url(tdf_settings()->getRegisterPageUrl()); ?>">
                                            <span class="listivo-menu-desktop-login-register-link__register-text listivo-menu-item-depth-0">
                                                <?php echo esc_html(tdf_string('register')); ?>
                                            </span>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if (tdf_settings()->showMenuCtaButton()) : ?>
                    <a
                            class="listivo-button listivo-button--primary-1"
                            href="<?php echo esc_url($lstCurrentWidget->getCtaButtonUrl()); ?>"
                    >
                        <span>
                            <?php echo esc_html(tdf_string('add_listing')); ?>

                            <?php if ($lstCurrentWidget->hasCtaButtonIcon()) : ?>
                                <i class="<?php echo esc_attr($lstCurrentWidget->getCtaButtonIcon()); ?>"></i>
                            <?php else : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
                                     fill="none">
                                    <path d="M5.00488 11.525V7.075H0.854883V5.125H5.00488V0.65H7.00488V5.125H11.1549V7.075H7.00488V11.525H5.00488Z"
                                          fill="#FDFDFE"></path>
                                </svg>
                            <?php endif; ?>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
