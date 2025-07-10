<?php

namespace Tangibledesign\Framework\Providers\Account;

use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\VerifyReCaptcha;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\General\PanelWidget;
use WP_User;

class LoginServiceProvider extends ServiceProvider
{
    use VerifyReCaptcha;

    /**
     * @var bool
     */
    private bool $confirmationMode = false;

    public function afterInitiation(): void
    {
        add_action('admin_post_nopriv_' . tdf_prefix() . '/user/login', [$this, 'login']);

        add_action('admin_post_' . tdf_prefix() . '/user/logout', [$this, 'logout']);

        add_action('wp_login', [$this, 'assignModels'], 10, 2);

        add_action(tdf_prefix() . '/confirmation/mode', function ($mode) {
            $this->confirmationMode = $mode;
        });
    }

    /**
     * @param string $login
     * @param WP_User $user
     * @return void
     * @throws JsonException
     */
    public function assignModels(string $login, WP_User $user): void
    {
        $currentUser = tdf_user_factory()->create($user);
        if (!$currentUser) {
            return;
        }

        if (!$currentUser->isConfirmed() && tdf_settings()->isUserEmailConfirmationEnabled()) {
            return;
        }

        $cookieKey = tdf_prefix() . '/model/new';
        if (empty($_COOKIE[$cookieKey])) {
            return;
        }

        $modelId = (int)$_COOKIE[$cookieKey];
        if (empty($modelId)) {
            return;
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return;
        }

        if (!empty($model->getUserId())) {
            return;
        }

        $model->setUser($user->ID);

        setcookie(tdf_prefix() . '/model/new', 0, time() + (60 * 60), '/');

        if (tdf_settings()->paymentsEnabled()) {
            if (!$this->confirmationMode) {
                $this->successJsonResponse([
                    'reload' => true,
                    'redirect' => PanelWidget::getUrl(PanelWidget::ACTION_SELECT_PACKAGE) . '?id=' . $model->getId(),
                ]);
            } else {
                wp_safe_redirect(PanelWidget::getUrl(PanelWidget::ACTION_SELECT_PACKAGE) . '?id=' . $model->getId());
            }
            exit;
        }

        if (tdf_settings()->moderationEnabled()) {
            $model->setPending();
        } elseif (!$model->isPublished()) {
            $model->setPublish();

            if (!empty(tdf_settings()->getListingExpireAfter())) {
                $model->setExpireDateFromDays(tdf_settings()->getListingExpireAfter());
            }
        }
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function login(): void
    {
        /** @noinspection NotOptimalIfConditionsInspection */
        if (tdf_settings()->reCaptchaEnabled() && !$this->verifyReCaptcha('login', $_POST['token'] ?? '')) {
            $this->errorJsonResponse();
            return;
        }

        if (!isset($_POST['nonce'], $_POST['login'], $_POST['password'])) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('something_went_wrong')
            ]);
            return;
        }

        if (empty($_POST['nonce']) || empty($_POST['login']) || empty($_POST['password'])) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('something_went_wrong')
            ]);
            return;
        }

        $login = $_POST['login'];
        $password = $_POST['password'];
        $remember = !empty('remember');
        $nonce = $_POST['nonce'];

        if (!wp_verify_nonce($nonce, tdf_prefix() . '_login')) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('something_went_wrong')
            ]);
            return;
        }

        $user = wp_signon([
            'user_login' => $login,
            'user_password' => $password,
            'remember' => $remember
        ]);

        if (is_wp_error($user)) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('invalid_username_or_password'),
            ]);
            return;
        }

        if (tdf_settings()->isUserEmailConfirmationEnabled()) {
            $u = new User($user);
            if (!$u->isConfirmed()) {
                do_action(tdf_prefix() . '/logout');

                $this->errorJsonResponse([
                    'title' => tdf_string('success'),
                    'message' => tdf_string('email_confirmation_message'),
                    'type' => 'confirmation',
                ]);
                return;
            }
        }

        $this->successJsonResponse([
            'title' => tdf_string('success'),
            'message' => tdf_string('your_are_now_logged_in'),
        ]);
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function logout(): void
    {
        if (!wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_logout')) {
            return;
        }

        do_action(tdf_prefix() . '/logout');

        $this->successJsonResponse();
    }

}