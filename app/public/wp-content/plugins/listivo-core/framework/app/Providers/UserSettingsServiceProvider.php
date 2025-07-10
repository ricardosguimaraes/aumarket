<?php

namespace Tangibledesign\Framework\Providers;

use JsonException;
use Tangibledesign\Framework\Actions\Images\UploadImageAction;
use Tangibledesign\Framework\Core\Notification;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\User\User;

class UserSettingsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/user/settings/save', [$this, 'saveSettings']);

        add_action('admin_post_' . tdf_prefix() . '/user/socials/save', [$this, 'saveSocials']);

        add_action('admin_post_' . tdf_prefix() . '/user/changePassword', [$this, 'changePassword']);

        add_action('admin_post_' . tdf_prefix() . '/user/changeEmail', [$this, 'changeEmail']);

        add_action('admin_post_' . tdf_prefix() . '/user/changeEmailConfirmation', [$this, 'changeEmailConfirmation']);

        add_action('admin_post_' . tdf_prefix() . '/user/image/save', [$this, 'saveImage']);

        add_action('admin_post_' . tdf_prefix() . '/user/image/delete', [$this, 'deleteImage']);

        add_action('admin_post_' . tdf_prefix() . '/user/setPhone', [$this, 'setPhone']);

        add_filter('send_email_change_email', static function () {
            return false;
        });

        add_action('wp_ajax_' . tdf_prefix() . '/user/cover_image/save', [ $this, 'saveCoverImage' ]);
        add_action('wp_ajax_nopriv_' . tdf_prefix() . '/user/cover_image/save', [ $this, 'saveCoverImage' ]);
        add_action('wp_ajax_' . tdf_prefix() . '/user/cover_image/delete', [ $this, 'deleteCoverImage' ]);
        add_action('wp_ajax_nopriv_' . tdf_prefix() . '/user/cover_image/delete', [ $this, 'deleteCoverImage' ]);
    }

    public function setPhone(): void
    {
        if (!wp_verify_nonce($_POST['nonce'] ?? '', tdf_prefix() . '/user/setPhone')) {
            $this->errorJsonResponse();
            return;
        }

        $phone = trim($_POST['phone'] ?? '');
        $countryCode = trim($_POST['countryCode'] ?? '');

        if (empty($phone)) {
            $this->errorJsonResponse();
            return;
        }

        $user = tdf_current_user();
        if (!$user instanceof User) {
            $this->errorJsonResponse();
            return;
        }

        if (!$user->setPhone($phone)) {
            $this->errorJsonResponse([
                'title' => tdf_string('phone_exists_title'),
                'message' => tdf_string('phone_exists'),
            ]);
            return;
        }

        if (tdf_settings()->isPhoneCountryCodeSelectEnabled()) {
            $user->setPhoneCountryCode($countryCode);
        }

        if (tdf_settings()->isChatAppsOnRegistrationActivated()) {
            if (!tdf_settings()->disableWhatsApp()) {
                $user->setWhatsApp((int)($_POST['whatsAppEnabled'] ?? 0));
            }

            if (!tdf_settings()->disableViber()) {
                $user->setViber((int)($_POST['viberEnabled'] ?? 0));
            }
        }

        $this->successJsonResponse();
    }

    public function deleteImage(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_delete_user_image')) {
            return;
        }

        $user = tdf_current_user();
        if (!$user instanceof User) {
            return;
        }

        if ($user->hasSocialImage()) {
            $user->setSocialImage('');
        } else {
            $user->setImage(0);
        }
    }

    /**
     * @return void
     * @throws JsonException
     */
    public function saveImage(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_save_user_image')) {
            return;
        }

        $user = tdf_current_user();
        if (!$user instanceof User) {
            return;
        }

        $imageId = (new UploadImageAction())->execute('file', 'user_profile');

        if ($user->hasSocialImage()) {
            $user->setSocialImage('');
        }

        if (!empty($user->getImageId())) {
            wp_delete_attachment($user->getImageId(), true);
        }

        $user->setImage($imageId);

        echo json_encode([
            'id' => $imageId,
            'url' => $user->getImageUrl()
        ], JSON_THROW_ON_ERROR);
    }

    public function changePassword(): void
    {
        if (!wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_change_password')) {
            $this->errorJsonResponse();
            return;
        }

        $oldPassword = $_POST['oldPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';

        if (empty($oldPassword) || empty($newPassword)) {
            $this->errorJsonResponse();
            return;
        }

        $user = tdf_current_user();
        if (!$user instanceof User) {
            $this->errorJsonResponse();
            return;
        }

        if (!wp_check_password($oldPassword, $user->getPasswordHash(), $user->getId())) {
            $this->errorJsonResponse([
                'title' => tdf_string('old_password_error'),
            ]);
            return;
        }

        $user->setPassword($newPassword);

        $this->successJsonResponse();
    }

    public function saveSettings(): void
    {
        if (!wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_save_user_settings')) {
            $this->errorJsonResponse();
            return;
        }

        $user = tdf_current_user();
        if (!$user) {
            $this->errorJsonResponse();
            return;
        }

        $userData = $_POST['user'] ?? [];

        if (!$user->setPhone($userData['phone'] ?? '')) {
            $this->errorJsonResponse();
            return;
        }

        $user->setDisplayName($userData['name'] ?? '');
        $user->setAddress($userData['address'] ?? '');
        $user->setDescription($userData['description'] ?? '');
        $user->setWhatsApp((int)($userData['whatsApp'] ?? ''));
        $user->setViber((int)($userData['viber'] ?? ''));
        $user->setWebsite($userData['website'] ?? '');

        if (tdf_settings()->isMarketingConsentsEnabled()) {
            $user->setMarketingConsent($userData['marketingConsent'] ?? 0);
        }

        if (tdf_settings()->isPhoneCountryCodeSelectEnabled()) {
            $user->setPhoneCountryCode($userData['phoneCountryCode'] ?? '');
        }

        if (tdf_settings()->isAccountTypeEnabled() && tdf_settings()->canUserChangeAccountType()) {
            $user->setAccountType($userData['accountType'] ?? '');
        }

        if ($user->isBusinessAccount() && tdf_settings()->isCompanyInformationEnabled()) {
            $user->setCompanyInformation($userData['companyInformation'] ?? '');
        }

        if (
            ($user->isBusinessAccount() && tdf_settings()->isFullNameEnabledForBusinessAccount())
            || ($user->isPrivateAccount() && tdf_settings()->isFullNameEnabledForPrivateAccount())
        ) {
            $user->setFirstName($userData['firstName'] ?? '');
            $user->setLastName($userData['lastName'] ?? '');
        }

        $this->successJsonResponse();
    }

    public function saveSocials(): void
    {
        if (!wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_save_user_socials')) {
            $this->errorJsonResponse();
            return;
        }

        $user = tdf_current_user();
        if (!$user) {
            $this->errorJsonResponse();
            return;
        }

        $userSocials = $_POST['socials'] ?? [];

        $user->setYouTubeProfile($userSocials['youtube'] ?? '');
        $user->setFacebookProfile($userSocials['facebook'] ?? '');
        $user->setInstagramProfile($userSocials['instagram'] ?? '');
        $user->setLinkedInProfile($userSocials['linkedin'] ?? '');
        $user->setTwitterProfile($userSocials['twitter'] ?? '');
        $user->setTiktokProfile($userSocials['tiktok'] ?? '');
        $user->setTelegramProfile($userSocials['telegram'] ?? '');
        $user->setEbayProfile($userSocials['ebay'] ?? '');

        $this->successJsonResponse();
    }

    public function changeEmail(): void
    {
        if (!wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_new_email')) {
            $this->errorJsonResponse();
            return;
        }

        $user = tdf_current_user();
        if (!$user) {
            $this->errorJsonResponse();
            return;
        }

        $email = $_POST['newEmail'] ?? '';
        if (empty($email) || !is_email($email)) {
            $this->errorJsonResponse();
            return;
        }

        $check = get_user_by('email', $email);
        if ($check !== false && $check->ID !== get_current_user_id()) {
            $this->errorJsonResponse();
            return;
        }

        do_action(tdf_prefix() . '/notification/' . Notification::CHANGE_EMAIL, $user);

        $user->setTempNewEmail($email);

        $this->successJsonResponse();
    }

    public function changeEmailConfirmation(): void
    {
        if (!wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_new_email')) {
            $this->errorJsonResponse();
            return;
        }

        $user = tdf_current_user();
        if (!$user) {
            $this->errorJsonResponse();
            return;
        }

        $pin = (int)($_POST['pin'] ?? 0);
        $userPin = $user->getChangeEmailToken();

        if (empty($pin) || $pin !== $userPin) {
            $this->errorJsonResponse();
            return;
        }

        $email = $_POST['newEmail'] ?? '';
        if (empty($email) || !is_email($email)) {
            $this->errorJsonResponse();
            return;
        }

        $tempNewEmail = $user->getTempNewEmail();
        if ($email !== $tempNewEmail) {
            $this->errorJsonResponse();
            return;
        }

        $user->setEmail($email);

        $this->successJsonResponse();
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function saveCoverImage(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_save_user_cover_image')) {
            return;
        }

        $user = tdf_current_user();
        if (!$user instanceof User) {
            return;
        }

        $imageId = (new \Tangibledesign\Framework\Actions\Images\UploadImageAction())->execute('file', 'user_cover');

        if (!empty($user->getCoverImageId())) {
            wp_delete_attachment($user->getCoverImageId(), true);
        }

        $user->setCoverImage($imageId);

        echo json_encode([
            'id' => $imageId,
            'url' => $user->getCoverImageUrl()
        ], JSON_THROW_ON_ERROR);
    }

    public function deleteCoverImage(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_delete_user_cover_image')) {
            return;
        }

        $user = tdf_current_user();
        if (!$user instanceof User) {
            return;
        }

        if (!empty($user->getCoverImageId())) {
            wp_delete_attachment($user->getCoverImageId(), true);
            $user->setCoverImage(0);
        }

        echo json_encode(['success' => true], JSON_THROW_ON_ERROR);
    }
}