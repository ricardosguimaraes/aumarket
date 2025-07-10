<?php

namespace Tangibledesign\Framework\Providers\Panel;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Widgets\General\PanelWidget;
use WP_Post;

class PanelRedirectServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('template_redirect', [$this, 'handle']);
    }

    public function handle(): void
    {
        if ($this->verifyPhoneRedirect()) {
            wp_safe_redirect(PanelWidget::getUrl(PanelWidget::ACTION_VERIFY_PHONE));
            exit;
        }

        if ($this->setPhoneRedirect() ) {
            wp_safe_redirect(PanelWidget::getUrl(PanelWidget::ACTION_SET_PHONE));
            exit;
        }

        if ($this->userHasRedirect()) {
            $this->userRedirect();
            exit;
        }

        if (!is_page()) {
            return;
        }

        global $post;
        if (!$post) {
            return;
        }

        if (is_user_logged_in()) {
            if ($this->redirectFromLoginToPanel()) {
                wp_redirect(tdf_settings()->getPanelPageUrl());
                exit;
            }

            $this->handleAction();
            return;
        }

        if ($post->ID !== tdf_settings()->getPanelPageId()) {
            return;
        }

        if (PanelWidget::getAction() === PanelWidget::ACTION_CREATE && tdf_settings()->submitWithoutLogin()) {
            return;
        }

        wp_redirect(tdf_settings()->getLoginPageUrl());
        exit;
    }

    private function handleAction(): void
    {
        if (tdf_current_user()->canCreateModels()) {
            return;
        }

        $action = PanelWidget::getAction();
        if (empty($action)) {
            return;
        }

        if (in_array($action, [
            PanelWidget::ACTION_CREATE,
            PanelWidget::ACTION_EDIT,
            PanelWidget::ACTION_LIST,
            PanelWidget::ACTION_MY_ORDERS,
            PanelWidget::ACTION_MY_PACKAGES,
            PanelWidget::ACTION_BUY_PACKAGE,
            PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_CANCEL,
            PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_SUCCESS,
            PanelWidget::ACTION_SUBSCRIPTION_CANCELED,
            PanelWidget::ACTION_PROMOTE,
            PanelWidget::ACTION_SELECT_SUBSCRIPTION,
            PanelWidget::ACTION_SELECT_SUBSCRIPTION_SUCCESS,
            PanelWidget::ACTION_SELECT_SUBSCRIPTION_CANCEL,
            PanelWidget::ACTION_EXTEND,
            PanelWidget::ACTION_BUMP_UP,
        ], true)) {
            if (tdf_settings()->isFavoriteEnabled()) {
                wp_redirect(PanelWidget::getUrl(PanelWidget::ACTION_FAVORITES));
                exit;
            }

            wp_redirect(PanelWidget::getUrl(PanelWidget::ACTION_SETTINGS));
            exit;
        }
    }

    private function isPanelPage(): bool
    {
        if (!empty(get_query_var(PanelWidget::ACTION))) {
            return true;
        }

        global $post;
        if (!$post instanceof WP_Post) {
            return false;
        }

        return $post->ID === tdf_settings()->getPanelPageId();
    }

    private function verifyPhoneRedirect(): bool
    {
        if (!$this->isPanelPage()) {
            return false;
        }

        /** @noinspection NullPointerExceptionInspection */
        return is_user_logged_in()
            && tdf_settings()->isUserPhoneVerificationEnabled()
            && tdf_current_user()->hasPhone()
            && !tdf_current_user()->isVerified()
            && PanelWidget::getAction() !== PanelWidget::ACTION_VERIFY_PHONE
            && PanelWidget::getAction() !== PanelWidget::ACTION_SET_PHONE;
    }

    private function setPhoneRedirect(): bool
    {
        if (!$this->isPanelPage()) {
            return false;
        }

        /** @noinspection NullPointerExceptionInspection */
        return is_user_logged_in()
            && tdf_settings()->isPhoneRequired()
            && !tdf_current_user()->hasPhone()
            && PanelWidget::getAction() !== PanelWidget::ACTION_SET_PHONE;
    }

    private function userHasRedirect(): bool
    {
        /** @noinspection NullPointerExceptionInspection */
        return is_user_logged_in() && tdf_current_user()->hasRedirectUrl();
    }

    /** @noinspection NullPointerExceptionInspection */
    private function userRedirect(): void
    {
        $redirectUrl = tdf_current_user()->getRedirectUrl();

        tdf_current_user()->clearRedirectUrl();

        wp_safe_redirect($redirectUrl);
    }

    private function redirectFromLoginToPanel(): bool
    {
        global $post;
        if (!$post) {
            return false;
        }

        return !current_user_can('manage_options')
            && tdf_settings()->getLoginPageId() === $post->ID;
    }

}