<?php

namespace Tangibledesign\Framework\Actions\Panel;

use Tangibledesign\Framework\Widgets\General\PanelWidget;

class GetPanelTitleAction
{
    /**
     * @param  string  $action
     * @return string
     */
    public function execute(string $action): string
    {
        if ($action === PanelWidget::ACTION_LIST) {
            return tdf_string('models');
        }

        if ($action === PanelWidget::ACTION_CREATE) {
            return tdf_string('add_listing');
        }

        if ($action === PanelWidget::ACTION_EDIT) {
            return tdf_string('edit_model');
        }

        if ($action === PanelWidget::ACTION_SETTINGS) {
            return tdf_string('settings');
        }

        if ($action === PanelWidget::ACTION_MODERATION) {
            return tdf_string('moderation');
        }

        if ($action === PanelWidget::ACTION_MESSAGES) {
            return tdf_string('messages');
        }

        if ($action === PanelWidget::ACTION_FAVORITES) {
            return tdf_string('favorites');
        }

        if ($action === PanelWidget::ACTION_SELECT_PACKAGE) {
            return tdf_string('choose_a_package');
        }

        if ($action === PanelWidget::ACTION_MY_PACKAGES) {
            return tdf_string('my_packages');
        }

        if ($action === PanelWidget::ACTION_BUY_PACKAGE) {
            return tdf_string('buy_the_package');
        }

        if ($action === PanelWidget::ACTION_PROMOTE) {
            return tdf_string('promote');
        }

        if ($action === PanelWidget::ACTION_EXTEND) {
            return tdf_string('extend');
        }

        if ($action === PanelWidget::ACTION_BUMP_UP) {
            return tdf_string('bump_up');
        }

        if ($action === PanelWidget::ACTION_MY_ORDERS) {
            return tdf_string('my_orders');
        }

        if ($action === PanelWidget::ACTION_ORDERS) {
            return tdf_string('orders');
        }

        if ($action === PanelWidget::ACTION_VERIFY_PHONE) {
            return tdf_string('verify_phone_number');
        }

        if ($action === PanelWidget::ACTION_SELECT_SUBSCRIPTION) {
            return tdf_string('choose_a_subscription');
        }

        return '';
    }

}