<?php

if (!tdf_settings()->subscriptionsEnabled()) {
    return;
}

use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Listivo\Widgets\General\PanelWidget;

/* @var PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstCurrentUser = tdf_current_user();
if (!$lstCurrentUser instanceof User) {
    return;
}

if (!$lstCurrentUser->canCreateModels()) {
    return;
}

$userSubscription = $lstCurrentUser->getUserSubscription();
if (!$userSubscription instanceof UserSubscription) {
    return;
}
?>
<div
        class="listivo-panel-accordions__item listivo-panel-accordion"
        :class="{'listivo-panel-accordion--active': accordions.open === 'subscription'}"
>
    <div
            class="listivo-panel-accordion__top"
            @click="accordions.onOpen('subscription')"
    >
        <div class="listivo-panel-accordion__label">
            <?php echo esc_html(tdf_string('subscription')); ?>
        </div>

        <div class="listivo-panel-accordion__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14"
                 viewBox="0 0 16 14"
                 fill="none">
                <path d="M6.0872 0.243733C6.25012 0.0808152 6.46304 -0.000435034 6.67637 -0.000435034C6.88971 -0.000435034 7.10263 0.0808152 7.26554 0.243733C7.59096 0.569152 7.59096 1.09666 7.26554 1.42208L2.85468 5.83294L14.1764 5.83294C14.6364 5.83294 15.0098 6.20627 15.0098 6.66628C15.0098 7.12628 14.6364 7.49962 14.1764 7.49962L2.85468 7.49962L7.26554 11.9105C7.59096 12.2359 7.59096 12.7634 7.26554 13.0888C6.94013 13.4142 6.41262 13.4142 6.0872 13.0888L0.25383 7.25545C-0.0715891 6.93003 -0.0715891 6.40253 0.25383 6.07711L6.0872 0.243733Z"
                      fill="#2A3946"/>
            </svg>
        </div>
    </div>

    <div class="listivo-panel-accordion__content-wrapper listivo-panel-accordion__content-wrapper--subscription">
        <div class="listivo-panel-accordion__content">
            <div class="listivo-panel-subscription">
                <div class="listivo-panel-subscription__head">
                    <div class="listivo-panel-subscription__name">
                        <?php echo esc_html($lstCurrentUser->getSubscriptionName()); ?>
                    </div>

                    <a
                            class="listivo-panel-subscription__change"
                            href="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_SELECT_SUBSCRIPTION)); ?>"
                    >
                        (<?php echo esc_html(tdf_string('change_plan')); ?>)
                    </a>
                </div>

                <div class="listivo-panel-subscription__content">
                    <div class="listivo-panel-subscription__info">
                        <?php if ($userSubscription->isFree()) : ?>
                            <?php echo esc_html(tdf_string('current_period_ends')) ?>
                        <?php else : ?>
                            <?php echo esc_html(tdf_string('next_bill_date')) ?>
                        <?php endif; ?>

                        <?php echo esc_html(date_i18n(get_option('date_format'), $userSubscription->getCurrentPeriodEnd()->getTimestamp())); ?>
                    </div>

                    <?php if (!$userSubscription->isFree()) :
                        $subscription = $userSubscription->getSubscription();
                        if ($subscription) :?>
                            <div class="listivo-panel-subscription__info">
                                <?php echo esc_html(tdf_string('your_current_monthly_payment_is')) ?>

                                <?php echo esc_html($userSubscription->getSubscription()->getDisplayPrice()); ?>
                            </div>
                        <?php endif; ?>

                        <div class="listivo-panel-subscription__info">
                            <?php echo esc_html($userSubscription->getStripePaymentMethod()); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (!$userSubscription->isFree()) : ?>
                    <div class="listivo-panel-subscription__buttons">
                        <a
                                class="listivo-simple-button listivo-simple-button--background-primary-1"
                                href="<?php echo esc_url(admin_url('admin-post.php?action=tdf/subscriptions/paymentMethod/update')); ?>"
                        >
                            <?php echo esc_html(tdf_string('update_payment_method')); ?>
                        </a>

                        <lst-cancel-subscription
                                request-url="<?php echo esc_url(admin_url('admin-post.php?action=tdf/userSubscription/cancelCurrentUser')); ?>"
                                warning-title="<?php echo esc_html(tdf_string('cancel_subscription_warning_title')); ?>"
                                warning-text="<?php echo esc_html(tdf_string('cancel_subscription_warning_text')); ?>"
                                success-title="<?php echo esc_html(tdf_string('cancel_subscription_success_title')); ?>"
                                success-text="<?php echo esc_html(tdf_string('cancel_subscription_success_text')); ?>"
                                error-title="<?php echo esc_html(tdf_string('cancel_subscription_error_title')); ?>"
                                error-text="<?php echo esc_html(tdf_string('cancel_subscription_error_text')); ?>"
                                confirm-button-text="<?php echo esc_html(tdf_string('confirm')); ?>"
                                cancel-button-text="<?php echo esc_html(tdf_string('cancel')); ?>"
                                ok-button-text="<?php echo esc_html(tdf_string('ok')); ?>"
                                redirect-url="<?php echo esc_url(PanelWidget::getUrl(PanelWidget::ACTION_LIST)); ?>"
                        >
                            <button
                                    slot-scope="cancelProps"
                                    @click.prevent="cancelProps.onClick"
                                    class="listivo-simple-button listivo-simple-button--background-color-3 listivo-simple-button--color-1"
                            >
                                <?php echo esc_html(tdf_string('cancel')); ?>
                            </button>
                        </lst-cancel-subscription>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
