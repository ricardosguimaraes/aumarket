<?php

use Tangibledesign\Framework\Models\Payments\Order;
use Tangibledesign\Framework\Models\Payments\OrderStatus;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

/* @var Order $lstCurrentOrder */
global $lstCurrentOrder;

$lstUser = $lstCurrentOrder->getUser();
?>
<div class="listivo-panel-orders__row">
    <div class="listivo-panel-orders__main-col">
        <div class="listivo-panel-order">
            <h3 class="listivo-panel-order__heading">
                <?php
                $orderLabel = $lstCurrentOrder->getLabel();
                if (!empty($orderLabel)) : ?>
                    <span><?php echo esc_html($orderLabel); ?></span>
                <?php endif; ?>

                <span class="listivo-panel-order__order">
                    (<?php echo esc_html(tdf_string('order')); ?>
                    #<?php echo esc_html($lstCurrentOrder->getOrderId()); ?>)
                </span>
            </h3>

            <div class="listivo-panel-order__info">
                <?php if ($lstUser) : ?>
                    <a
                            class="listivo-panel-order__user"
                            href="<?php echo esc_url($lstUser->getUrl()); ?>"
                            target="_blank"
                    >
                        <span class="listivo-panel-order__avatar">
                            <?php if (!empty($lstUser->getImageUrl('listivo_100_100'))): ?>
                                <img
                                        class="lazyload"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                        data-src="<?php echo esc_url($lstUser->getImageUrl('listivo_100_100')); ?>"
                                        alt="<?php echo esc_attr($lstUser->getDisplayName()); ?>"
                                >
                            <?php else : ?>
                                <div class="listivo-user-image-placeholder listivo-user-image-placeholder--circle">
                                    <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            width="20"
                                            height="20"
                                            viewBox="0 0 132 148"
                                            fill="none"
                                    >
                                        <path d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                                              stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </span>

                        <span class="listivo-panel-order__user-name">
                            <?php echo esc_html($lstUser->getDisplayName()); ?>
                        </span>
                    </a>
                <?php endif; ?>

                <div class="listivo-panel-order__attributes">
                    <?php if ($lstCurrentOrder->getCreatedAt() !== null) : ?>
                        <div class="listivo-panel-order__meta">
                            <span><?php echo esc_html(tdf_string('created')); ?>:</span>

                            <?php echo esc_html(date_i18n(get_option('date_format'), $lstCurrentOrder->getCreatedAt()->getTimestamp())); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (
                        $lstCurrentOrder->getUpdatedAt() !== null
                        && $lstCurrentOrder->getCreatedAt() !== null
                        && $lstCurrentOrder->getCreatedAt()->format(get_option('date_format')) !== $lstCurrentOrder->getUpdatedAt()->format(get_option('date_format'))
                    ) : ?>
                        <div class="listivo-panel-order__meta">
                            <span><?php echo esc_html(tdf_string('modified')); ?>:</span>

                            <?php echo esc_html(date_i18n(get_option('date_format'), $lstCurrentOrder->getCreatedAt()->getTimestamp())); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="listivo-panel-order__status listivo-panel-order__status--show-tablet">
                    <div class="listivo-panel-order-status listivo-panel-order-status--<?php echo esc_attr($lstCurrentOrder->getStatus()); ?> listivo-panel-orders__status--hide-mobile">
                        <?php echo esc_html($lstCurrentOrder->getFormattedStatus()); ?>
                    </div>
                </div>

                <div class="listivo-panel-order__data">
                    <div class="listivo-panel-order__price">
                        <?php echo wp_kses_post($lstCurrentOrder->getPrice()); ?>

                        <?php if (!empty($lstCurrentOrder->getPaymentMethod())) : ?>
                            <span class="listivo-panel-order__payment-method">
                                <?php echo esc_html(tdf_string('via') . ' ' . $lstCurrentOrder->getPaymentMethod()); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if (!empty($lstCurrentOrder->getInvoiceUrl())) : ?>
                    <div class="listivo-panel-order__attributes">
                        <div class="listivo-panel-order__meta">
                            <span><?php echo esc_html(tdf_string('invoice')); ?>:</span>

                            <a href="<?php echo esc_url($lstCurrentOrder->getInvoiceUrl()); ?>" target="_blank">
                                <?php echo esc_html(tdf_string('download')); ?>
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="listivo-panel-orders__col listivo-panel-orders__col--contact">
        <div class="listivo-panel-orders__contact">
            <?php if ($lstUser) : ?>
                <a
                        class="listivo-social-icon listivo-social-icon--color-1"
                        href="mailto:<?php echo esc_attr($lstUser->getMail()); ?>"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M0 10C0 4.48604 4.48603 0 10 0C15.514 0 20 4.48604 20 10C20 15.514 15.514 20 10 20C4.48603 20 0 15.514 0 10ZM18.5011 10.0001C18.5011 5.29677 14.7044 1.50007 10.0011 1.50007C5.29781 1.50007 1.50112 5.29677 1.50112 10.0001C1.50112 14.7034 5.29781 18.5001 10.0011 18.5001C14.7044 18.5001 18.5011 14.7034 18.5011 10.0001ZM10.0022 2.99997C6.14496 2.99997 3.00223 6.14269 3.00223 9.99997C3.00223 13.8572 6.14496 17 10.0022 17C10.8658 17 11.6964 16.8432 12.4622 16.5556C12.7161 16.4637 12.901 16.2423 12.9462 15.976C12.9915 15.7098 12.8901 15.4398 12.6808 15.2691C12.4714 15.0984 12.1866 15.0534 11.9348 15.1513C11.3347 15.3767 10.6847 15.5 10.0022 15.5C6.9555 15.5 4.50223 13.0467 4.50223 9.99997C4.50223 6.95324 6.9555 4.49997 10.0022 4.49997C13.049 4.49997 15.5022 6.95324 15.5022 9.99997V10.75C15.5022 11.4491 14.9513 12 14.2522 12C13.5531 12 13.0022 11.4491 13.0022 10.75V7.24997C13.0053 6.86862 12.7216 6.54571 12.3431 6.49948C11.9646 6.45326 11.6116 6.69843 11.5227 7.0693C11.0166 6.7121 10.4111 6.49997 9.75223 6.49997C7.92633 6.49997 6.50223 8.1137 6.50223 9.99997C6.50223 11.8862 7.92633 13.5 9.75223 13.5C10.6776 13.5 11.4984 13.084 12.0843 12.4297C12.589 13.078 13.3739 13.5 14.2522 13.5C15.7621 13.5 17.0022 12.2599 17.0022 10.75V9.99997C17.0022 6.14269 13.8595 2.99997 10.0022 2.99997ZM11.5022 9.99997C11.5022 8.85323 10.6833 7.99997 9.75223 7.99997C8.82114 7.99997 8.00223 8.85323 8.00223 9.99997C8.00223 11.1467 8.82114 12 9.75223 12C10.6833 12 11.5022 11.1467 11.5022 9.99997Z"
                              fill="#314352"/>
                    </svg>
                </a>

                <?php if ($lstUser->hasPhone()) : ?>
                    <a
                            class="listivo-social-icon listivo-social-icon--color-1"
                            href="tel:<?php echo esc_attr($lstUser->getPhoneUrl()); ?>"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="24" viewBox="0 0 14 24" fill="none">
                            <path d="M2.625 0C1.18562 0 0 1.18562 0 2.625V20.7083C0 22.1477 1.18562 23.3333 2.625 23.3333H11.375C12.8144 23.3333 14 22.1477 14 20.7083V2.625C14 1.18562 12.8144 0 11.375 0H2.625ZM2.625 1.75H11.375C11.8688 1.75 12.25 2.13121 12.25 2.625V20.7083C12.25 21.2021 11.8688 21.5833 11.375 21.5833H2.625C2.13121 21.5833 1.75 21.2021 1.75 20.7083V2.625C1.75 2.13121 2.13121 1.75 2.625 1.75ZM7 3.5C6.76794 3.5 6.54538 3.59219 6.38128 3.75628C6.21719 3.92038 6.125 4.14294 6.125 4.375C6.125 4.60706 6.21719 4.82962 6.38128 4.99372C6.54538 5.15781 6.76794 5.25 7 5.25C7.23206 5.25 7.45462 5.15781 7.61872 4.99372C7.78281 4.82962 7.875 4.60706 7.875 4.375C7.875 4.14294 7.78281 3.92038 7.61872 3.75628C7.45462 3.59219 7.23206 3.5 7 3.5ZM5.54167 18.0833C5.42572 18.0817 5.3106 18.1031 5.203 18.1464C5.09541 18.1896 4.99748 18.2538 4.9149 18.3352C4.83233 18.4166 4.76676 18.5136 4.722 18.6206C4.67725 18.7276 4.6542 18.8424 4.6542 18.9583C4.6542 19.0743 4.67725 19.1891 4.722 19.2961C4.76676 19.403 4.83233 19.5001 4.9149 19.5815C4.99748 19.6629 5.09541 19.7271 5.203 19.7703C5.3106 19.8136 5.42572 19.835 5.54167 19.8333H8.45833C8.57428 19.835 8.6894 19.8136 8.797 19.7703C8.90459 19.7271 9.00252 19.6629 9.0851 19.5815C9.16767 19.5001 9.23324 19.403 9.278 19.2961C9.32275 19.1891 9.3458 19.0743 9.3458 18.9583C9.3458 18.8424 9.32275 18.7276 9.278 18.6206C9.23324 18.5136 9.16767 18.4166 9.0851 18.3352C9.00252 18.2538 8.90459 18.1896 8.797 18.1464C8.6894 18.1031 8.57428 18.0817 8.45833 18.0833H5.54167Z"
                                  fill="#314352"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if ($lstUser->hasWhatsApp()) : ?>
                    <a
                            class="listivo-social-icon listivo-social-icon--color-1"
                            href="https://wa.me/<?php echo esc_attr($lstUser->getWhatsAppUrl()); ?>"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M17.0866 2.90667C15.2051 1.0337 12.7051 0 10.0423 0C4.55404 0 0.0846358 4.44589 0.0846358 9.90927C0.08138 11.6559 0.540365 13.3603 1.41276 14.8639L0 20L5.27995 18.6196C6.73177 19.4102 8.3724 19.825 10.0391 19.8283H10.0423C15.5306 19.8283 19.9967 15.3824 20 9.91575C20 7.26831 18.9648 4.77965 17.0866 2.90667ZM10.0423 18.1529H10.0391C8.55469 18.1529 7.09635 17.7544 5.82682 17.0058L5.52409 16.8276L2.38932 17.6442L3.22591 14.6047L3.0306 14.2936C2.20052 12.9812 1.76432 11.4647 1.76432 9.90927C1.76432 5.36941 5.47852 1.67531 10.0456 1.67531C12.2559 1.67531 14.3327 2.53403 15.8952 4.08944C17.4577 5.64809 18.3171 7.71549 18.3171 9.91575C18.3171 14.4588 14.6029 18.1529 10.0423 18.1529ZM14.5801 11.9831C14.3327 11.86 13.1087 11.2605 12.8809 11.1795C12.653 11.0953 12.487 11.0564 12.321 11.3027C12.1549 11.5522 11.6797 12.1095 11.5332 12.2748C11.39 12.4368 11.2435 12.4595 10.9961 12.3364C10.7454 12.2132 9.94466 11.9507 8.99414 11.105C8.25521 10.4504 7.75391 9.63707 7.61068 9.3908C7.46419 9.14128 7.5944 9.00843 7.7181 8.88529C7.83203 8.77511 7.96875 8.59689 8.09245 8.45107C8.21615 8.30849 8.25846 8.2048 8.3431 8.03953C8.42448 7.87427 8.38216 7.72845 8.32031 7.60531C8.25846 7.48218 7.76042 6.26053 7.55208 5.76474C7.35026 5.28192 7.14518 5.34997 6.99219 5.34025C6.84896 5.33377 6.68294 5.33377 6.51693 5.33377C6.35091 5.33377 6.08073 5.39533 5.85287 5.64485C5.625 5.89112 4.98372 6.4906 4.98372 7.70901C4.98372 8.92741 5.87565 10.1069 5.99935 10.2722C6.12305 10.4342 7.75391 12.9358 10.2507 14.0084C10.8431 14.2644 11.3053 14.4167 11.6667 14.5301C12.2624 14.7181 12.806 14.6922 13.2357 14.6306C13.7142 14.5593 14.707 14.0311 14.9154 13.4511C15.1204 12.8743 15.1204 12.3785 15.0586 12.2748C14.9967 12.1711 14.8307 12.1095 14.5801 11.9831Z"
                                  fill="#314352"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if ($lstUser->hasViber()) : ?>
                    <a
                            class="listivo-social-icon listivo-social-icon--color-1"
                            href="viber://chat?number=<?php echo esc_attr(str_replace('+', '',
                                $lstUser->getPhoneUrl())); ?>"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M9.39453 0.000822919C7.71556 0.0112151 4.31091 0.170769 2.1084 2.05975C2.0977 2.06878 2.08728 2.07809 2.07715 2.08768C0.63765 3.47269 0 5.45809 0 8.10344V9.53222C0 12.1776 0.641741 14.1671 2.10938 15.5778C2.1195 15.5877 2.12992 15.5973 2.14062 15.6066C2.77111 16.1465 3.58685 16.5439 4.5 16.8613V18.5703C4.5 19.1607 4.88598 19.6943 5.46387 19.9051C5.63816 19.9687 5.82111 20 6 20C6.41862 20 6.82705 19.8321 7.11621 19.5253C7.12544 19.5158 8.26645 18.3396 8.95703 17.6134C9.35881 17.6253 9.7707 17.6348 9.99902 17.6348C11.286 17.6348 15.374 17.7356 17.8916 15.5768C17.9023 15.5675 17.9127 15.5579 17.9229 15.548C19.3624 14.163 20 12.1776 20 9.53222L19.999 8.10344C19.999 5.45764 19.3581 3.46826 17.8906 2.05882C17.8805 2.04923 17.8701 2.03992 17.8594 2.0309C15.3688 -0.1033 11.287 0.000822919 10 0.000822919C9.83912 0.000822919 9.63438 -0.000661691 9.39453 0.000822919ZM10 1.43053C11.284 1.43053 15.0176 1.53765 16.8408 3.0855C17.962 4.17295 18.499 5.68205 18.499 8.10344L18.5 9.53315C18.4998 11.9531 17.9593 13.4662 16.873 14.5222C15.0133 16.1026 11.2831 16.2051 9.99902 16.2051C9.69152 16.2051 9.22986 16.2052 8.67188 16.1781C8.55998 16.1726 8.44822 16.1911 8.34479 16.2322C8.24137 16.2733 8.14891 16.3359 8.07422 16.4155C7.48299 17.046 6.00879 18.5601 6.00879 18.5601C6.00583 18.5631 6.0029 18.5662 6 18.5694V16.381C6.00003 16.2272 5.94797 16.0774 5.85155 15.954C5.75514 15.8305 5.61952 15.7401 5.46484 15.696C4.47543 15.4134 3.71088 15.0202 3.16016 14.553C2.03753 13.4638 1.5 11.9538 1.5 9.53222V8.10344C1.5 5.68356 2.04018 4.17049 3.12598 3.11435C4.98502 1.53356 8.71583 1.43053 10 1.43053ZM10 3.33774C9.724 3.33774 9.5 3.55125 9.5 3.81431C9.5 4.07738 9.724 4.29088 10 4.29088C12.481 4.29088 14.5 6.21527 14.5 8.58001V9.05658C14.5 9.31965 14.724 9.53315 15 9.53315C15.276 9.53315 15.5 9.31965 15.5 9.05658V8.58001C15.5 5.68961 13.0325 3.33774 10 3.33774ZM6.04492 3.81431C5.72542 3.81384 5.30646 3.96457 5.02246 4.16615C4.59546 4.46973 4.1488 4.88291 4.0293 5.3976C4.0133 5.46766 4.00398 5.53836 4.00098 5.6089C3.97798 6.14504 4.19802 6.68946 4.43652 7.1503C4.99802 8.2364 5.7413 9.28775 6.5498 10.2266C6.8083 10.5268 7.09034 10.8057 7.38184 11.0755C7.66484 11.3528 7.95746 11.6217 8.27246 11.8685C9.25746 12.6391 10.3605 13.3476 11.5 13.8828C11.979 14.1077 12.5426 14.3141 13.0996 14.2988C13.1791 14.2965 13.2594 14.2876 13.3389 14.2709C13.8789 14.1575 14.3124 13.7313 14.6309 13.3243C14.8424 13.0536 15.0005 12.6548 15 12.3498C14.9995 12.1696 14.9136 11.9973 14.7256 11.8462C14.1701 11.4001 13.9135 11.2659 13.1465 10.827C12.827 10.6444 12.3405 10.4863 12.085 10.4863C11.9105 10.4863 11.7012 10.6137 11.5732 10.7357C11.2452 11.0484 11.1375 11.4394 10.5625 11.4394C10 11.4394 9.0175 10.8938 8.3125 10.1884C7.5725 9.51647 7 8.58001 7 8.04387C7 7.49581 7.40345 7.38615 7.73145 7.07304C7.85945 6.95152 8 6.75256 8 6.58624C8 6.34271 7.83408 5.8855 7.64258 5.58097C7.18208 4.84944 7.04174 4.60486 6.57324 4.07587C6.41474 3.89668 6.23392 3.81479 6.04492 3.81431ZM10.2139 4.77583C9.94237 4.76153 9.70298 4.96327 9.68848 5.22634C9.67398 5.48893 9.88513 5.71329 10.1611 5.72711C11.7531 5.80717 13 7.0607 13 8.58001C13 8.84308 13.224 9.05658 13.5 9.05658C13.776 9.05658 14 8.84308 14 8.58001C14 6.55363 12.3374 4.88258 10.2139 4.77583ZM10.4268 6.26976C10.2337 6.29717 10.0674 6.43074 10.0156 6.62161C9.94662 6.87657 10.1075 7.13618 10.375 7.20243C10.8985 7.3311 11.3083 7.72264 11.4453 8.22351C11.5038 8.43797 11.7067 8.58001 11.9287 8.58001C11.9702 8.58001 12.0132 8.57467 12.0557 8.56419C12.3227 8.49747 12.4826 8.2374 12.4131 7.98244C12.1846 7.14749 11.5 6.49589 10.626 6.28C10.5589 6.26368 10.4911 6.26063 10.4268 6.26976Z"
                                  fill="#314352"/>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php if (tdf_settings()->messageSystem() && $lstUser->getId() !== get_current_user_id()) : ?>
                    <a
                            class="listivo-social-icon listivo-social-icon--color-1"
                            href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_MESSAGES) . '/?' . tdf_slug('user') . '=' . $lstUser->getId()); ?>"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                            <path d="M19.2243 2.63722e-05C19.1071 0.000998772 18.9916 0.028748 18.8868 0.0811549L0.425298 9.31177C0.306649 9.37109 0.205354 9.46008 0.131248 9.57009C0.0571415 9.68011 0.0127419 9.80742 0.00236002 9.93966C-0.00802183 10.0719 0.0159668 10.2046 0.0719969 10.3248C0.128027 10.445 0.214195 10.5488 0.322133 10.6259L3.70754 13.0447L5.16687 17.4226C5.21128 17.5558 5.29127 17.6742 5.39818 17.7652C5.50509 17.8562 5.63485 17.9161 5.77341 17.9386C5.91196 17.9611 6.05403 17.9453 6.18422 17.8928C6.31442 17.8403 6.42778 17.7532 6.51202 17.641L7.59575 16.1957L12.6238 19.8525C12.7216 19.9237 12.8348 19.9709 12.9543 19.9902C13.0737 20.0095 13.1961 20.0003 13.3113 19.9634C13.4266 19.9265 13.5315 19.8629 13.6176 19.7779C13.7036 19.6928 13.7684 19.5887 13.8067 19.4739L19.9605 1.01263C19.9992 0.896477 20.0097 0.772756 19.991 0.651754C19.9723 0.530751 19.9249 0.415962 19.8529 0.316927C19.7809 0.217893 19.6863 0.137474 19.577 0.082356C19.4677 0.0272379 19.3468 -0.000987358 19.2243 2.63722e-05ZM17.127 4.64639L12.6789 17.9895L8.55027 14.9878L17.127 4.64639ZM13.1827 4.6534L4.33655 11.6034L2.25522 10.116L13.1827 4.6534ZM14.0971 5.89036L6.84956 14.6302C6.84855 14.6312 6.84755 14.6322 6.84655 14.6332L6.84355 14.6372C6.83564 14.6467 6.82796 14.6564 6.82051 14.6663C6.81222 14.6767 6.80421 14.6874 6.79647 14.6983L6.16246 15.5426L5.26002 12.8334L14.0971 5.89036Z"
                                  fill="#314352"/>
                        </svg>
                    </a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="listivo-panel-orders__col listivo-panel-orders__col--hide-tablet listivo-panel-orders__col--status">
        <div class="listivo-panel-order-status listivo-panel-order-status--<?php echo esc_attr($lstCurrentOrder->getStatus()); ?>">
            <?php echo esc_html($lstCurrentOrder->getFormattedStatus()); ?>
        </div>
    </div>

    <div class="listivo-panel-orders__col listivo-panel-orders__col--actions">
        <div class="listivo-panel-orders__actions">
            <div class="listivo-panel-actions-button-wrapper">
                <button class="listivo-panel-actions-button">
                    <?php echo esc_html(tdf_string('actions')); ?>

                    <svg xmlns="http://www.w3.org/2000/svg" width="7" height="5" viewBox="0 0 7 5" fill="none">
                        <path d="M3.5 2.56768L5.87477 0.192917C6.13207 -0.0643854 6.54972 -0.0643854 6.80702 0.192917C7.06433 0.45022 7.06433 0.86787 6.80702 1.12517L3.9394 3.99279C3.6964 4.2358 3.30298 4.2358 3.0606 3.99279L0.192977 1.12517C-0.0643257 0.86787 -0.0643257 0.45022 0.192977 0.192917C0.45028 -0.0643854 0.86793 -0.0643854 1.12523 0.192917L3.5 2.56768Z"
                              fill="#2A3946"/>
                    </svg>
                </button>

                <div class="listivo-panel-actions listivo-panel-actions--hidden">
                    <?php if ($lstCurrentOrder->getStatus() !== OrderStatus::COMPLETED) : ?>
                        <a
                                class="listivo-panel-actions__action"
                                href="<?php echo esc_url(tdf_action_url('listivo/order/status&orderId=' . $lstCurrentOrder->getId()) . '&status=' . OrderStatus::COMPLETED); ?>"
                        >
                            <?php echo esc_html(tdf_string('completed')); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($lstCurrentOrder->getStatus() !== OrderStatus::PROCESSING) : ?>
                        <a
                                class="listivo-panel-actions__action"
                                href="<?php echo esc_url(tdf_action_url('listivo/order/status&orderId=' . $lstCurrentOrder->getId()) . '&status=' . OrderStatus::PROCESSING); ?>"
                        >
                            <?php echo esc_html(tdf_string('processing')); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($lstCurrentOrder->getStatus() !== OrderStatus::PENDING) : ?>
                        <a
                                class="listivo-panel-actions__action"
                                href="<?php echo esc_url(tdf_action_url('listivo/order/status&orderId=' . $lstCurrentOrder->getId()) . '&status=' . OrderStatus::PENDING); ?>"
                        >
                            <?php echo esc_html(tdf_string('pending')); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($lstCurrentOrder->getStatus() !== OrderStatus::ON_HOLD) : ?>
                        <a
                                class="listivo-panel-actions__action"
                                href="<?php echo esc_url(tdf_action_url('listivo/order/status&orderId=' . $lstCurrentOrder->getId()) . '&status=' . OrderStatus::ON_HOLD); ?>"
                        >
                            <?php echo esc_html(tdf_string('on_hold')); ?>
                        </a>
                    <?php endif; ?>


                    <?php if ($lstCurrentOrder->getStatus() !== OrderStatus::REFUNDED) : ?>
                        <a
                                class="listivo-panel-actions__action"
                                href="<?php echo esc_url(tdf_action_url('listivo/order/status&orderId=' . $lstCurrentOrder->getId()) . '&status=' . OrderStatus::REFUNDED); ?>"
                        >
                            <?php echo esc_html(tdf_string('refunded')); ?>
                        </a>
                    <?php endif; ?>

                    <?php if ($lstCurrentOrder->getStatus() !== OrderStatus::FAILED) : ?>
                        <a
                                class="listivo-panel-actions__action"
                                href="<?php echo esc_url(tdf_action_url('listivo/order/status&orderId=' . $lstCurrentOrder->getId()) . '&status=' . OrderStatus::FAILED); ?>"
                        >
                            <?php echo esc_html(tdf_string('failed')); ?>
                        </a>
                    <?php endif; ?>

                    <lst-delete-order
                            request-url="<?php echo esc_url(tdf_action_url('listivo/order/delete')); ?>"
                            :order-id="<?php echo esc_attr($lstCurrentOrder->getId()); ?>"
                            title-string="<?php echo esc_attr(tdf_string('are_you_sure')); ?>"
                            text-string="<?php echo esc_attr(tdf_string('delete_order_text')); ?>"
                            confirm-button-text="<?php echo esc_attr(tdf_string('confirm')); ?>"
                            cancel-button-text="<?php echo esc_attr(tdf_string('cancel')); ?>"
                    >
                        <button
                                class="listivo-panel-actions__action"
                                slot-scope="deleteOrderProps"
                                type="button"
                                @click.prevent.stop="deleteOrderProps.onDelete"
                        >
                            <?php echo esc_html(tdf_string('delete')); ?>
                        </button>
                    </lst-delete-order>
                </div>
            </div>
        </div>
    </div>
</div>