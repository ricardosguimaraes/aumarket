<?php

namespace Tangibledesign\Framework\Providers\Account;

use Tangibledesign\Framework\Core\Notification;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\VerifyReCaptcha;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\User\User;

class EmailConfirmationServiceProvider extends ServiceProvider
{
    use VerifyReCaptcha;

    public function afterInitiation(): void
    {
        add_action('admin_post_nopriv_' . tdf_prefix() . '/user/confirmation', [$this, 'confirmation']);

        add_action('admin_post_nopriv_' . tdf_prefix() . '/user/sendConfirmationMail', [$this, 'sendConfirmationMail']);

        add_filter('sanitize_user', static function ($username, $rawUserName, $strict) {
            if (!$strict) {
                return $username;
            }

            return sanitize_user(stripslashes($rawUserName), false);
        }, 10, 3);

        add_action('init', function () {
            add_rewrite_rule(
                tdf_slug('email_confirmation') . '/?$',
                'index.php?' . tdf_prefix() . '-custom-url=email-confirmation',
                'top'
            );
        });

        add_filter('template_include', function ($template) {
            if (get_query_var(tdf_prefix() . '-custom-url') !== 'email-confirmation') {
                return $template;
            }

            $this->confirmation();

            return '';
        });
    }

    public function sendConfirmationMail(): void
    {
        /** @noinspection NotOptimalIfConditionsInspection */
        if (tdf_settings()->reCaptchaEnabled() && !$this->verifyReCaptcha('login', $_POST['token'] ?? '')) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('something_went_wrong')
            ]);
            return;
        }

        if (!$this->verifyNonce()) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('something_went_wrong')
            ]);
            return;
        }

        if (!tdf_settings()->userRegistrationOpen()) {
            return;
        }

        $email = $_POST['email'] ?? '';
        if (empty($email)) {
            return;
        }

        $user = tdf_user_factory()->createByEmail($email);
        if (!$user) {
            $this->successJsonResponse([
                'title' => tdf_string('success'),
                'message' => tdf_string('confirmation_link_sent')
            ]);

            return;
        }

        if ($user->isConfirmed()) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('user_already_confirmed')
            ]);

            return;
        }

        do_action(tdf_prefix() . '/notification/' . Notification::MAIL_CONFIRMATION, $user);

        $this->successJsonResponse([
            'title' => tdf_string('success'),
            'message' => tdf_string('confirmation_link_sent'),
        ]);
    }

    public function confirmation(): void
    {
        if (!isset($_GET['selector'], $_GET['v'])) {
            return;
        }

        $selector = $_GET['selector'];
        $validator = $_GET['v'];

        $userId = User::verifyConfirmation($selector, $validator);
        if (!$userId) {
            wp_redirect(tdf_settings()->getLoginPageUrl());
            exit;
        }

        $user = tdf_user_factory()->create($userId);
        if (!$user) {
            return;
        }

        $user->setConfirmed();

        do_action(tdf_prefix() . '/confirmation/mode', true);

        do_action('tdf/user/registered', $user);

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_WELCOME, [
            'user' => $user->getId(),
        ]);

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_REGISTERED, [
            'user' => $user->getId(),
        ]);

        $user->login();

        wp_redirect(apply_filters(tdf_prefix() . '/user/confirmation/redirectUrl', tdf_app('after_register_redirect_url')));
        exit;
    }

    private function verifyNonce(): bool
    {
        return wp_verify_nonce($_POST['nonce'] ?? '', tdf_prefix() . '_login');
    }

}