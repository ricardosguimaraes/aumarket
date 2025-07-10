<?php

namespace Tangibledesign\Framework\Actions\Panel;

use Tangibledesign\Framework\Widgets\General\PanelWidget;

class GetCurrentActionAction
{

    public function execute(): string
    {
        $action = get_query_var(PanelWidget::ACTION);

        if (empty($action)) {
            return $this->handleEmptyAction();
        }

        if (tdf_slug(PanelWidget::ACTION_LIST) === $action) {
            return PanelWidget::ACTION_LIST;
        }

        if (tdf_slug(PanelWidget::ACTION_CREATE) === $action) {
            return PanelWidget::ACTION_CREATE;
        }

        if (tdf_slug(PanelWidget::ACTION_EDIT) === $action) {
            return PanelWidget::ACTION_EDIT;
        }

        if (tdf_slug(PanelWidget::ACTION_SETTINGS) === $action) {
            return PanelWidget::ACTION_SETTINGS;
        }

        if (tdf_slug(PanelWidget::ACTION_MODERATION) === $action && tdf_current_user() && tdf_current_user()->isModerator()) {
            return PanelWidget::ACTION_MODERATION;
        }

        if (tdf_slug(PanelWidget::ACTION_MESSAGES) === $action && tdf_settings()->messageSystem()) {
            return PanelWidget::ACTION_MESSAGES;
        }

        if (tdf_slug(PanelWidget::ACTION_FAVORITES) === $action && tdf_settings()->isFavoriteEnabled()) {
            return PanelWidget::ACTION_FAVORITES;
        }

        if (tdf_settings()->paymentsEnabled()) {
            $paymentAction = $this->handlePaymentActions($action);
            if (!empty($paymentAction)) {
                return $paymentAction;
            }
        }

        if (tdf_slug(PanelWidget::ACTION_VERIFY_PHONE) === $action && tdf_settings()->isUserPhoneVerificationEnabled()) {
            return PanelWidget::ACTION_VERIFY_PHONE;
        }

        if (tdf_slug(PanelWidget::ACTION_SET_PHONE) === $action) {
            return PanelWidget::ACTION_SET_PHONE;
        }

        /** @noinspection NullPointerExceptionInspection */
        if (
            tdf_slug(PanelWidget::ACTION_ORDERS) === $action
            && tdf_settings()->paymentsEnabled()
            && tdf_current_user()->canSeeOrders()
        ) {
            return PanelWidget::ACTION_ORDERS;
        }

        return $this->handleEmptyAction();
    }

    private function handlePaymentActions(string $action): string
    {
        if (tdf_slug(PanelWidget::ACTION_SELECT_PACKAGE) === $action) {
            return PanelWidget::ACTION_SELECT_PACKAGE;
        }

        if (tdf_slug(PanelWidget::ACTION_BUY_PACKAGE) === $action) {
            return PanelWidget::ACTION_BUY_PACKAGE;
        }

        if (tdf_slug(PanelWidget::ACTION_MY_PACKAGES) === $action) {
            return PanelWidget::ACTION_MY_PACKAGES;
        }

        if (tdf_slug(PanelWidget::ACTION_PROMOTE) === $action) {
            return PanelWidget::ACTION_PROMOTE;
        }

        if (tdf_slug(PanelWidget::ACTION_EXTEND) === $action) {
            return PanelWidget::ACTION_EXTEND;
        }

        if (tdf_slug(PanelWidget::ACTION_BUMP_UP) === $action) {
            return PanelWidget::ACTION_BUMP_UP;
        }

        if (tdf_slug(PanelWidget::ACTION_MY_ORDERS) === $action) {
            return PanelWidget::ACTION_MY_ORDERS;
        }

        if (tdf_slug(PanelWidget::ACTION_ORDERS) === $action) {
            return PanelWidget::ACTION_ORDERS;
        }

        if (tdf_settings()->subscriptionsEnabled()) {
            return $this->handleSubscriptionActions($action);
        }

        return '';
    }

    private function handleSubscriptionActions(string $action): string
    {
        if (tdf_slug(PanelWidget::ACTION_SELECT_SUBSCRIPTION) === $action) {
            return PanelWidget::ACTION_SELECT_SUBSCRIPTION;
        }

        if (tdf_slug(PanelWidget::ACTION_SELECT_SUBSCRIPTION_SUCCESS) === $action) {
            return PanelWidget::ACTION_SELECT_SUBSCRIPTION_SUCCESS;
        }

        if (tdf_slug(PanelWidget::ACTION_SELECT_SUBSCRIPTION_CANCEL) === $action) {
            return PanelWidget::ACTION_SELECT_SUBSCRIPTION_CANCEL;
        }

        if (tdf_slug(PanelWidget::ACTION_SUBSCRIPTION_CANCELED) === $action) {
            return PanelWidget::ACTION_SUBSCRIPTION_CANCELED;
        }

        if (tdf_slug(PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_SUCCESS) === $action) {
            return PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_SUCCESS;
        }

        if (tdf_slug(PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_CANCEL) === $action) {
            return PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_CANCEL;
        }

        return '';
    }

    private function handleEmptyAction(): string
    {
        if ($this->canCurrentUserCreateModels()) {
            return PanelWidget::ACTION_LIST;
        }

        if (tdf_settings()->isFavoriteEnabled()) {
            return PanelWidget::ACTION_FAVORITES;
        }

        return PanelWidget::ACTION_SETTINGS;
    }

    private function canCurrentUserCreateModels(): bool
    {
        if (!is_user_logged_in()) {
            return tdf_settings()->submitWithoutLogin();
        }

        return tdf_current_user()->canCreateModels();
    }

}