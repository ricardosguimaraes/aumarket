<?php


namespace Tangibledesign\Framework\Providers\Account;


use JsonException;
use Tangibledesign\Framework\Core\Notification;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\VerifyNonce;
use Tangibledesign\Framework\Helpers\VerifyReCaptcha;
use Tangibledesign\Framework\Models\User\User;

/**
 * Class ResetPasswordServiceProvider
 * @package Tangibledesign\Framework\Providers\Account
 */
class ResetPasswordServiceProvider extends ServiceProvider
{
    use VerifyReCaptcha;
    use VerifyNonce;

    public function afterInitiation(): void
    {
        add_action('admin_post_nopriv_'.tdf_prefix().'/user/resetPassword', [$this, 'resetPassword']);

        add_action('admin_post_'.tdf_prefix().'/user/resetPassword', [$this, 'resetPassword']);

        add_action('admin_post_nopriv_'.tdf_prefix().'/user/setPassword', [$this, 'setPassword']);
    }

    public function resetPassword(): void
    {
        if (!$this->verifyNonce($this->getNonce(), tdf_prefix().'_reset_password')) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('something_went_wrong'),
            ]);
            return;
        }

        if (
            tdf_settings()->reCaptchaEnabled()
            && !$this->verifyReCaptcha('reset_password', $this->getReCaptchaToken())
        ) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('something_went_wrong'),
            ]);
            return;
        }

        $this->sendResetPasswordMail();

        $this->successJsonResponse([
            'title' => tdf_string('check_your_email'),
            'message' => tdf_string('reset_password_link_sent'),
        ]);
    }

    /**
     * @return string
     */
    private function getReCaptchaToken(): string
    {
        return $_POST['token'] ?? '';
    }

    /**
     * @return string
     */
    private function getNonce(): string
    {
        return $_POST['nonce'] ?? '';
    }

    private function sendResetPasswordMail(): void
    {
        $user = tdf_user_factory()->createByEmail((string)$_POST['email']);
        if (!$user) {
            return;
        }

        do_action(tdf_prefix().'/notification/'.Notification::RESET_PASSWORD, $user, $user->getResetPasswordLink());
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function setPassword(): void
    {
        if (!isset($_POST['selector'], $_POST['v'], $_POST['nonce'], $_POST['password'])) {
            return;
        }

        $password = $_POST['password'];
        $selector = $_POST['selector'];
        $validator = $_POST['v'];

        if (empty($selector) || empty($validator) || empty($password)) {
            return;
        }

        if (!$this->verifyNonce($this->getNonce(), tdf_prefix().'_set_password')) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('something_went_wrong')
            ]);
            return;
        }

        /** @noinspection NotOptimalIfConditionsInspection */
        if (tdf_settings()->reCaptchaEnabled() && !$this->verifyReCaptcha('set_password', $_POST['token'] ?? '')) {
            $this->verifyReCaptcha('set_password', $this->getReCaptchaToken());
            return;
        }

        $userId = User::verifyResetPasswordToken($selector, $validator);
        if (!$userId) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('reset_password_link_invalid_or_expired')
            ]);
            return;
        }

        $user = tdf_user_factory()->create($userId);
        if (!$user) {
            $this->errorJsonResponse();
            return;
        }

        $user->setPassword($password);

        $user->clearResetPasswordTokenData();

        $user->setSource('panel');

        $this->successJsonResponse([
            'title' => tdf_string('success'),
            'message' => tdf_string('password_changed')
        ]);
    }

}