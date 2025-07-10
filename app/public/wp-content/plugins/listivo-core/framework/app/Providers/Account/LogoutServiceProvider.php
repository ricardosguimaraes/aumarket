<?php


namespace Tangibledesign\Framework\Providers\Account;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class LogoutServiceProvider
 * @package Tangibledesign\Framework\Providers\Account
 */
class LogoutServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/logout', [$this, 'logout']);
        add_action(tdf_prefix() . '/logout', [$this, 'logoutAction']);
    }

    public function logout(): void
    {
        $this->logoutAction();

        wp_safe_redirect($this->getRedirectUrl());
        exit;
    }

    public function logoutAction(): void
    {
        wp_destroy_current_session();
        wp_clear_auth_cookie();
        wp_set_current_user(0);

        do_action(tdf_prefix() . '/social/logout');
    }

    /**
     * @return string
     */
    private function getRedirectUrl(): string
    {
        $redirectUrl = tdf_settings()->getLoginPageUrl();
        if (empty($redirectUrl)) {
            return site_url();
        }

        return $redirectUrl;
    }

}