<?php

namespace Tangibledesign\Framework\Providers\Users;

use Tangibledesign\Framework\Actions\Users\Verify\Twilio\CheckVerificationTokenAction;
use Tangibledesign\Framework\Actions\Users\Verify\Twilio\SendVerificationTokenAction;
use Tangibledesign\Framework\Core\ServiceProvider;

class VerifyUserServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action(tdf_prefix() . '/users/sendVerificationToken', [$this, 'send']);
        add_action('admin_post_' . tdf_prefix() . '/users/verify', [$this, 'verify']);
    }

    public function send(): void
    {
        $user = tdf_current_user();
        if (!$user) {
            return;
        }

        (new SendVerificationTokenAction())->execute($user);
    }

    public function verify(): void
    {
        $token = $_POST['token'] ?? '';

        if (empty($token)) {
            $this->errorJsonResponse();
            return;
        }

        $user = tdf_current_user();
        if (!$user) {
            $this->errorJsonResponse();
            return;
        }

        if (!(new CheckVerificationTokenAction())->execute($user, $token)) {
            $this->errorJsonResponse();
            return;
        }

        $user->setVerified();

        $this->successJsonResponse();
    }
}