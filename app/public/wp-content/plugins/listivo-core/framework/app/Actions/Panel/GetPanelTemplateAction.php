<?php

namespace Tangibledesign\Framework\Actions\Panel;

use Tangibledesign\Framework\Widgets\General\PanelWidget;

class GetPanelTemplateAction
{

    public function execute(string $action): string
    {
        if ($action === PanelWidget::ACTION_LIST) {
            return 'templates/widgets/general/panel/list';
        }

        if ($action === PanelWidget::ACTION_CREATE) {
            return 'templates/widgets/general/panel/create';
        }

        if ($action === PanelWidget::ACTION_EDIT) {
            return 'templates/widgets/general/panel/edit';
        }

        if ($action === PanelWidget::ACTION_SETTINGS) {
            return 'templates/widgets/general/panel/settings';
        }

        if ($action === PanelWidget::ACTION_MODERATION) {
            return 'templates/widgets/general/panel/moderation';
        }

        if ($action === PanelWidget::ACTION_MESSAGES) {
            return 'templates/widgets/general/panel/messages';
        }

        if ($action === PanelWidget::ACTION_FAVORITES) {
            return 'templates/widgets/general/panel/favorites';
        }

        if ($action === PanelWidget::ACTION_SELECT_PACKAGE) {
            return 'templates/widgets/general/panel/select_package';
        }

        if ($action === PanelWidget::ACTION_BUY_PACKAGE) {
            return 'templates/widgets/general/panel/buy_package';
        }

        if ($action === PanelWidget::ACTION_MY_PACKAGES) {
            return 'templates/widgets/general/panel/my_packages';
        }

        if ($action === PanelWidget::ACTION_PROMOTE) {
            return 'templates/widgets/general/panel/promote';
        }

        if ($action === PanelWidget::ACTION_EXTEND) {
            return 'templates/widgets/general/panel/extend';
        }

        if ($action === PanelWidget::ACTION_MY_ORDERS) {
            return 'templates/widgets/general/panel/my_orders';
        }

        if ($action === PanelWidget::ACTION_ORDERS) {
            return 'templates/widgets/general/panel/orders';
        }

        if ($action === PanelWidget::ACTION_BUMP_UP) {
            return 'templates/widgets/general/panel/bump_up';
        }

        if ($action === PanelWidget::ACTION_VERIFY_PHONE) {
            return 'templates/widgets/general/panel/verify_phone';
        }

        if ($action === PanelWidget::ACTION_SET_PHONE) {
            return 'templates/widgets/general/panel/set_phone';
        }

        if ($action === PanelWidget::ACTION_SELECT_SUBSCRIPTION) {
            return 'templates/widgets/general/panel/select_subscription';
        }

        if ($action === PanelWidget::ACTION_SELECT_SUBSCRIPTION_SUCCESS) {
            return 'templates/widgets/general/panel/select_subscription_success';
        }

        if ($action === PanelWidget::ACTION_SELECT_SUBSCRIPTION_CANCEL) {
            return 'templates/widgets/general/panel/select_subscription_cancel';
        }

        if ($action === PanelWidget::ACTION_SUBSCRIPTION_CANCELED) {
            return 'templates/widgets/general/panel/subscription_canceled';
        }

        if ($action === PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_SUCCESS) {
            return 'templates/widgets/general/panel/update_payment_method_success';
        }

        if ($action === PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_CANCEL) {
            return 'templates/widgets/general/panel/update_payment_method_cancel';
        }

        return '';
    }

}