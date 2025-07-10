<?php

namespace Tangibledesign\Framework\Providers\Account;

use Tangibledesign\Framework\Core\Notification;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\VerifyReCaptcha;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use Tangibledesign\Framework\Validators\UserValidator;
use WP_Error;

class RegisterServiceProvider extends ServiceProvider
{
    use VerifyReCaptcha;

    public function afterInitiation(): void
    {
        add_action('admin_post_nopriv_' . tdf_prefix() . '/user/register', [$this, 'register']);
    }

    public function register(): void
    {
        if (!tdf_settings()->userRegistrationOpen()) {
            $this->errorJsonResponse();
            return;
        }

        $postData = $this->getPostData();
        /** @noinspection NotOptimalIfConditionsInspection */
        if (
            (tdf_settings()->reCaptchaEnabled() && !$this->verifyReCaptcha('register', $_POST['token'] ?? ''))
            || !$this->verifyNonce()
            || !(new UserValidator())->validate($postData)
        ) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('something_went_wrong'),
            ]);
            return;
        }

        if (tdf_settings()->isUserPhoneUnique() && !$this->checkIfPhoneIsUnique()) {
            $this->errorJsonResponse([
                'title' => tdf_string('ops'),
                'message' => tdf_string('phone_exists'),
            ]);
            return;
        }

        $this->registerUser($postData);
    }

    private function getPostData(): array
    {
        return [
            'name' => sanitize_user(stripslashes($_POST['name']), false),
            'email' => $_POST['email'] ?? '',
            'password' => $_POST['password'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'phoneCountryCode' => $_POST['phoneCountryCode'] ?? '',
            'accountType' => $_POST['accountType'] ?? UserSettingKey::ACCOUNT_TYPE_PRIVATE,
            'firstName' => $_POST['firstName'] ?? '',
            'lastName' => $_POST['lastName'] ?? '',
            'companyInformation' => $_POST['companyInformation'] ?? '',
            'marketingConsent' => !empty($_POST['marketingConsent']) ? 1 : 0,
            'viberEnabled' => !empty($_POST['viberEnabled']) ? 1 : 0,
            'whatsAppEnabled' => !empty($_POST['whatsAppEnabled']) ? 1 : 0,
        ];
    }

    private function registerUser(array $postData): void
    {
        extract($postData, EXTR_SKIP);

        remove_action('register_new_user', 'wp_send_new_user_notifications');

        $userId = register_new_user($name, $email);
        if (is_wp_error($userId)) {
            $this->handleWpError($userId);
            return;
        }

        $user = tdf_user_factory()->create((int)$userId);
        if (!$user) {
            return;
        }

        $user->setPassword($password);
        $user->setDisplayName($name);
        $user->setSource('panel');
        $user->setRole(tdf_prefix() . '_user');
        $user->setAccountType($accountType);
        $user->setPhoneCountryCode($phoneCountryCode);
        $user->setMarketingConsent($marketingConsent);
        $user->setViber($viberEnabled);
        $user->setWhatsApp($whatsAppEnabled);

        if ($accountType === UserSettingKey::ACCOUNT_TYPE_BUSINESS && tdf_settings()->isFullNameEnabledForBusinessAccount()) {
            $user->setFirstName($firstName);

            $user->setLastName($lastName);
        }

        if ($accountType === UserSettingKey::ACCOUNT_TYPE_BUSINESS && tdf_settings()->isCompanyInformationEnabled()) {
            $user->setCompanyInformation($companyInformation);
        }

        if ($accountType === UserSettingKey::ACCOUNT_TYPE_PRIVATE && tdf_settings()->isFullNameEnabledForPrivateAccount()) {
            $user->setFirstName($firstName);

            $user->setLastName($lastName);
        }

        $user->setPhone($phone);

        if (tdf_settings()->isUserEmailConfirmationEnabled()) {
            do_action(tdf_prefix() . '/notification/' . Notification::MAIL_CONFIRMATION, $user);

            $this->successJsonResponse([
                'title' => tdf_string('success'),
                'message' => tdf_string('email_confirmation_message'),
                'reload' => false,
            ]);
            return;
        }

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_WELCOME, [
            'user' => $user->getId(),
        ]);

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_REGISTERED, [
            'user' => $user->getId(),
        ]);

        $user->login();

        do_action('tdf/user/registered', $user);

        $this->successJsonResponse([
            'title' => tdf_string('success'),
            'message' => tdf_string('account_created'),
            'reload' => true,
        ]);
    }

    private function checkIfPhoneIsUnique(): bool
    {
        $phone = $_POST['phone'] ?? '';
        if (empty($phone)) {
            return true;
        }

        return tdf_query_users()->wherePhone($phone)->get()->count() === 0;
    }

    private function verifyNonce(): bool
    {
        return wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_register');
    }

    private function handleWpError(WP_Error $error): void
    {
        $errorCode = $error->get_error_code();
        if ($errorCode === 'email_exists' || $errorCode === 'username_exists') {
            $message = tdf_string('email_or_username_exists');
        } else {
            $message = tdf_string('something_went_wrong');
        }

        $this->errorJsonResponse([
            'title' => tdf_string('ops'),
            'message' => $message,
        ]);
    }
}