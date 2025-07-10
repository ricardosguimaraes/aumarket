<?php

namespace Tangibledesign\Framework\Models\User;

use DateInterval;
use DateTime;
use Exception;
use Tangibledesign\Framework\Core\BaseModel;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use WP_Error;
use WP_User;

abstract class BaseUser extends BaseModel
{
    /**
     * @var WP_User
     */
    protected $user;

    public function __construct(WP_User $user)
    {
        $this->user = $user;
    }

    public function getId(): int
    {
        return $this->user->ID;
    }

    public function getDisplayName(): string
    {
        return $this->user->display_name;
    }

    public function getFirstName(): string
    {
        return $this->user->first_name;
    }

    public function setFirstName(string $firstName): void
    {
        wp_update_user([
            'ID' => $this->getId(),
            'first_name' => $firstName,
        ]);
    }

    public function getLastName(): string
    {
        return $this->user->last_name;
    }

    public function setLastName(string $lastName): void
    {
        wp_update_user([
            'ID' => $this->getId(),
            'last_name' => $lastName,
        ]);
    }

    public function getDescription(): string
    {
        return $this->user->user_description;
    }

    public function setMeta(string $key, $value): bool
    {
        return update_user_meta($this->getId(), $key, $value) !== false;
    }

    public function getMeta(string $key)
    {
        return get_user_meta($this->getId(), $key, true);
    }

    public function getUrl(): string
    {
        return get_author_posts_url($this->getId());
    }

    public function getMail(): string
    {
        return $this->user->user_email;
    }

    public function getRegistrationDate(): string
    {
        return $this->user->user_registered;
    }

    public function getRegistrationDateDiff(): string
    {
        return human_time_diff(strtotime($this->getRegistrationDate()), time());
    }

    /**
     * @param  int  $confirmed
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setConfirmed($confirmed = 1): void
    {
        $this->setMeta(UserSettingKey::CONFIRMED, (int)$confirmed);
    }

    public function isConfirmed(): bool
    {
        return in_array('administrator', $this->user->roles, true)
            || !empty((int)$this->getMeta(UserSettingKey::CONFIRMED));
    }

    /**
     * @param  string  $selector
     * @param  string  $validator
     *
     * @return int|false
     */
    public static function verifyConfirmation(string $selector, string $validator)
    {
        if (empty($selector) || empty($validator)) {
            return false;
        }

        $user = tdf_user_factory()->createByMeta(UserSettingKey::CONFIRMATION_SELECTOR, $selector);
        if (!$user) {
            return false;
        }

        $expires = $user->getMeta(UserSettingKey::CONFIRMATION_EXPIRES);
        try {
            $now = new DateTime('now');
        } catch (Exception $e) {
            return false;
        }

        $now->format('Y-m-d\TH:i:s');
        if ($now->format('Y-m-d\TH:i:s') > $expires) {
            $user->clearConfirmationTokenData();

            return false;
        }

        $calc = hash('sha256', $validator);
        $token = $user->getMeta(UserSettingKey::CONFIRMATION_TOKEN);

        if (empty($calc) || empty($token)) {
            return false;
        }

        if (!hash_equals($calc, $token)) {
            return false;
        }

        $user->clearConfirmationTokenData();

        return $user->getId();
    }

    public function clearConfirmationTokenData(): void
    {
        $this->setMeta(UserSettingKey::CONFIRMATION_TOKEN, '0');

        $this->setMeta(UserSettingKey::CONFIRMATION_SELECTOR, '0');

        $this->setMeta(UserSettingKey::CONFIRMATION_EXPIRES, '0');
    }

    /**
     * @return bool|string
     */
    public function getConfirmationUrl()
    {
        try {
            $selector = bin2hex(random_bytes(8));
            $token = random_bytes(32);
            $expires = new DateTime('NOW');
            $expires->add(new DateInterval('P1D'));
        } catch (Exception $e) {
            return false;
        }

        $this->setMeta(UserSettingKey::CONFIRMATION_SELECTOR, $selector);
        $this->setMeta(UserSettingKey::CONFIRMATION_TOKEN, hash('sha256', bin2hex($token)));
        $this->setMeta(UserSettingKey::CONFIRMATION_EXPIRES, $expires->format('Y-m-d\TH:i:s'));

        return site_url().'/'.tdf_slug('email_confirmation').'/?'.http_build_query([
                'selector' => $selector,
                'v' => bin2hex($token)
            ]);
    }

    /**
     * @return string
     */
    public function getResetPasswordLink()
    {
        try {
            $selector = bin2hex(random_bytes(8));
            $token = bin2hex(random_bytes(32));
            $expires = new DateTime('NOW');
            $expires->add(new DateInterval('PT01H'));
        } catch (Exception $e) {
            return false;
        }

        $this->setMeta(UserSettingKey::RESET_PASSWORD_SELECTOR, $selector);
        $this->setMeta(UserSettingKey::RESET_PASSWORD_TOKEN, hash('sha256', $token));
        $this->setMeta(UserSettingKey::RESET_PASSWORD_EXPIRES, $expires->format('Y-m-d\TH:i:s'));

        $loginPageUrl = tdf_settings()->getLoginPageUrl();
        $baseUrl = strpos($loginPageUrl, '?') === false
            ? $loginPageUrl.'?'
            : $loginPageUrl.'&';

        return $baseUrl.http_build_query([
                tdf_slug('view') => tdf_slug('set-password'),
                'selector' => $selector,
                'v' => $token
            ]);
    }

    /**
     * @param  string  $selector
     * @param  string  $validator
     *
     * @return bool|int
     */
    public static function verifyResetPasswordToken(string $selector, string $validator)
    {
        $user = tdf_user_factory()->createByMeta(UserSettingKey::RESET_PASSWORD_SELECTOR, $selector);
        if (!$user) {
            return false;
        }

        $expires = $user->getMeta(UserSettingKey::RESET_PASSWORD_EXPIRES);
        try {
            $now = new DateTime('now');
        } catch (Exception $e) {
            return false;
        }

        $now->format('Y-m-d\TH:i:s');
        if ($now->format('Y-m-d\TH:i:s') > $expires) {
            $user->clearResetPasswordTokenData();

            return false;
        }

        $calc = hash('sha256', $validator);
        $token = $user->getMeta(UserSettingKey::RESET_PASSWORD_TOKEN);

        if (empty($calc) || empty($token)) {
            return false;
        }

        if (!hash_equals($calc, $token)) {
            return false;
        }

        return $user->getId();
    }

    public function clearResetPasswordTokenData(): void
    {
        $this->setMeta(UserSettingKey::RESET_PASSWORD_TOKEN, '0');

        $this->setMeta(UserSettingKey::RESET_PASSWORD_EXPIRES, '0');

        $this->setMeta(UserSettingKey::RESET_PASSWORD_SELECTOR, '0');
    }

    public function login(): void
    {
        wp_set_auth_cookie($this->getId());

        do_action('wp_login', $this->user->user_login, $this->user);

        do_action(tdf_prefix().'/userLogged');
    }

    /**
     * @param  string  $source
     */
    public function setSource(string $source): void
    {
        $this->setMeta(tdf_prefix().'_source', $source);
    }

    /**
     * @param  string  $displayName
     */
    public function setDisplayName(string $displayName): void
    {
        wp_update_user([
            'display_name' => $displayName,
            'ID' => $this->getId(),
        ]);
    }

    /**
     * @param  string  $password
     */
    public function setPassword(string $password): void
    {
        wp_set_password($password, $this->getId());
    }

    /**
     * @param  string  $role
     */
    public function setRole(string $role): void
    {
        wp_update_user([
            'ID' => $this->getId(),
            'role' => $role,
        ]);
    }

    /**
     * @param  string  $description
     */
    public function setDescription(string $description): void
    {
        wp_update_user([
            'ID' => $this->getId(),
            'description' => $description,
        ]);
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->user->user_pass;
    }

    /**
     * @return int
     * @throws Exception
     */
    public function createChangeEmailToken(): int
    {
        $token = random_int(100000, 999999);
        $expires = new DateTime('NOW');
        $expires->add(new DateInterval('PT01H'));

        $this->setMeta(UserSettingKey::CHANGE_EMAIL_TOKEN, $token);
        $this->setMeta(UserSettingKey::CHANGE_EMAIL_EXPIRE, $expires->format('Y-m-d\TH:i:s'));

        return $token;
    }

    /**
     * @return int|false
     */
    public function getChangeEmailToken()
    {
        $token = $this->getMeta(UserSettingKey::CHANGE_EMAIL_TOKEN);
        if (empty($token)) {
            return false;
        }

        $expires = $this->getMeta(UserSettingKey::CHANGE_EMAIL_EXPIRE);
        try {
            $now = new DateTime('now');
        } catch (Exception $e) {
            return false;
        }

        $now->format('Y-m-d\TH:i:s');
        if ($now->format('Y-m-d\TH:i:s') > $expires) {
            return false;
        }

        return (int)$token;
    }

    /**
     * @param  string  $email
     */
    public function setTempNewEmail(string $email): void
    {
        $this->setMeta(UserSettingKey::CHANGE_EMAIL_TEMP, $email);
    }

    /**
     * @return string
     */
    public function getTempNewEmail(): string
    {
        return (string)$this->getMeta(UserSettingKey::CHANGE_EMAIL_TEMP);
    }

    /**
     * @param  string  $email
     * @return bool
     */
    public function setEmail(string $email): bool
    {
        return !wp_update_user([
                'ID' => $this->getId(),
                'user_email' => $email
            ]) instanceof WP_Error;
    }

    /**
     * @return string
     */
    public function getUserRole(): string
    {
        foreach ($this->user->roles as $role) {
            return $role;
        }

        return '';
    }

    public function isAdministrator(): bool
    {
        return in_array('administrator', $this->user->roles, true);
    }

}