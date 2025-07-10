<?php

namespace Tangibledesign\Framework\Providers\Account;

use Hybridauth\Exception\Exception;
use Hybridauth\Hybridauth;
use Hybridauth\Provider\Facebook;
use Hybridauth\Provider\Google;
use Hybridauth\User\Profile;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\User\User;
use Hybridauth\Adapter\OAuth2;

class SocialAuthServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('wp_logout', [$this, 'logout']);
        add_action(tdf_prefix() . '/social/logout', [$this, 'logout']);

        add_action('admin_post_nopriv_' . tdf_prefix() . '/socialAuth/google', [$this, 'google']);

        add_action('admin_post_nopriv_' . tdf_prefix() . '/socialAuth/facebook', [$this, 'facebook']);

        add_action('init', static function () {
            add_rewrite_rule('social-auth/([a-z0-9-]+)[/]?$', 'index.php?social_auth=$matches[1]', 'top');
        });

        add_filter('query_vars', static function ($vars) {
            $vars[] = 'social_auth';
            return $vars;
        });

        add_action('template_redirect', function () {
            if (!get_query_var('social_auth')) {
                return;
            }

            if (get_query_var('social_auth') === 'google') {
                $this->google();
            }

            if (get_query_var('social_auth') === 'facebook') {
                $this->facebook();
            }

            exit;
        });

        add_action('delete_user', [$this, 'handleUserDeletion']);
        add_action('remove_user_from_blog', [$this, 'handleUserDeletion']);
    }

    public function logout(): void
    {
        if (!tdf_settings()->googleAuth()) {
            return;
        }

        if (empty(tdf_settings()->getGoogleAuthClientId()) || empty(tdf_settings()->getGoogleAuthClientSecret())) {
            return;
        }

        $adapter = new Google($this->getGoogleConfig());
        if ($adapter->isConnected()) {
            $adapter->disconnect();
        }
    }

    public function facebook(): void
    {
        $adapter = new Facebook([
            'callback' => site_url() . '/social-auth/facebook/',
            'keys' => [
                'id' => tdf_settings()->getFacebookAuthAppId(),
                'secret' => tdf_settings()->getFacebookAuthAppSecret()
            ],
            'photo_size' => 400,
        ]);

        try {
            $adapter->authenticate();

            $profile = $adapter->getUserProfile();
        } catch (Exception $e) {
            try {
                $adapter->setAccessToken(null);
                $adapter->authenticate();
                $profile = $adapter->getUserProfile();
            } catch (Exception $e) {
                wp_redirect(tdf_settings()->getLoginPageUrl());
                exit;
            }
        }

        if (!$profile) {
            wp_redirect(tdf_settings()->getLoginPageUrl());
            exit;
        }

        $this->auth($profile);

        $adapter->disconnect();
    }

    private function setUserImage(User $user, Profile $profile): void
    {
        if (!empty($profile->photoURL)) {
            $user->setSocialImage($profile->photoURL);
        }
    }

    private function auth(Profile $profile): void
    {
        if (empty($profile->emailVerified)) {
            wp_redirect(tdf_settings()->getLoginPageUrl());
            exit;
        }

        $user = tdf_user_factory()->createByEmail($profile->emailVerified);
        if ($user) {
            do_action(tdf_prefix() . '/confirmation/mode', true);

            $user->login();

            wp_redirect(apply_filters(
                tdf_prefix() . '/socialAuth/redirectUrl',
                tdf_app('after_social_login_redirect_url')
            ));
            exit;
        }

        $userId = wp_create_user(
            $profile->displayName,
            substr(md5(mt_rand()), 0, 7),
            $profile->emailVerified
        );

        if (is_wp_error($userId)) {
            wp_redirect(tdf_settings()->getLoginPageUrl());
            exit;
        }

        $user = tdf_user_factory()->create($userId);
        if (!$user) {
            wp_redirect(tdf_settings()->getLoginPageUrl());
            exit;
        }

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_WELCOME, [
            'user' => $user->getId(),
        ]);

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_REGISTERED, [
            'user' => $user->getId(),
        ]);

        do_action('tdf/user/registered', $user);

        if (!empty($profile->phone)) {
            $user->setPhone($profile->phone);
        }

        $user->setConfirmed();

        $user->setSource('panel');

        $user->setRole($this->getUserRole());

        $this->setUserImage($user, $profile);

        do_action(tdf_prefix() . '/confirmation/mode', true);

        $user->login();

        wp_redirect(apply_filters(
            tdf_prefix() . '/socialAuth/redirectUrl',
            tdf_app('after_social_register_redirect_url')
        ));
        exit;
    }

    private function getUserRole(): string
    {
        return tdf_prefix() . '_user';
    }

    public function google(): void
    {
        $adapter = new Google($this->getGoogleConfig());

        try {
            $adapter->authenticate();
            $profile = $adapter->getUserProfile();
        } catch (Exception $e) {
            try {
                $adapter->setAccessToken(null);
                $adapter->authenticate();
                $profile = $adapter->getUserProfile();
            } catch (Exception $e) {
                wp_redirect(tdf_settings()->getLoginPageUrl());
                exit;
            }
        }

        if (!$profile) {
            wp_redirect(tdf_settings()->getLoginPageUrl());
            exit;
        }

        $this->auth($profile);
    }

    private function getGoogleConfig(): array
    {
        return [
            'callback' => site_url() . '/social-auth/google/',
            'keys' => [
                'id' => tdf_settings()->getGoogleAuthClientId(),
                'secret' => tdf_settings()->getGoogleAuthClientSecret()
            ],
            'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
            'authorize_url_parameters' => [
                'prompt' => 'select_account',
            ],
        ];
    }

    public function handleUserDeletion(int $userId): void
    {
        $user = tdf_user_factory()->create($userId);
        if (!$user) {
            return;
        }

        $this->revokeFacebookAccess($user);
    }

    private function revokeFacebookAccess(User $user): void
    {
        if (!tdf_settings()->showFacebookAuth()) {
            return;
        }

        try {
            $adapter = new Facebook([
                'callback' => site_url() . '/social-auth/facebook/',
                'keys' => [
                    'id' => tdf_settings()->getFacebookAuthAppId(),
                    'secret' => tdf_settings()->getFacebookAuthAppSecret()
                ]
            ]);

            if ($adapter instanceof OAuth2) {
                $adapter->apiRequest('me/permissions', 'DELETE');
            }
        } catch (Exception $e) {
            error_log('Facebook revoke access failed: ' . $e->getMessage());
        }
    }
}
