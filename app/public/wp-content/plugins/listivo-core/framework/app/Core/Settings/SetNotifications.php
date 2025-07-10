<?php /** @noinspection PhpUnused */


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetNotifications
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetNotifications
{
    use Setting;

    /**
     * @param int $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModelApprovedNotification($enable): void
    {
        $this->setSetting(SettingKey::MODEL_APPROVED_NOTIFICATION, (int)$enable);
    }

    /**
     * @return bool
     */
    public function modelApprovedNotification(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::MODEL_APPROVED_NOTIFICATION));
    }

    /**
     * @param string $title
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModelApprovedEmailTitle($title): void
    {
        $this->setSetting(SettingKey::MODEL_APPROVED_EMAIL_TITLE, $title);
    }

    /**
     * @return string
     */
    public function getModelApprovedEmailTitle(): string
    {
        return (string)$this->getSetting(SettingKey::MODEL_APPROVED_EMAIL_TITLE);
    }

    /**
     * @param string $message
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModelApprovedEmailMessage($message): void
    {
        $this->setSetting(SettingKey::MODEL_APPROVED_EMAIL_MESSAGE, $message);
    }

    /**
     * @return string
     */
    public function getModelApprovedEmailMessage(): string
    {
        return (string)$this->getSetting(SettingKey::MODEL_APPROVED_EMAIL_MESSAGE);
    }

    /**
     * @param int $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModelPendingNotification($enable): void
    {
        $this->setSetting(SettingKey::MODEL_PENDING_NOTIFICATION, (int)$enable);
    }

    /**
     * @return bool
     */
    public function modelPendingNotification(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::MODEL_PENDING_NOTIFICATION));
    }

    /**
     * @param string $title
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModelPendingEmailTitle($title): void
    {
        $this->setSetting(SettingKey::MODEL_PENDING_EMAIL_TITLE, $title);
    }

    /**
     * @return string
     */
    public function getModelPendingEmailTitle(): string
    {
        return (string)$this->getSetting(SettingKey::MODEL_PENDING_EMAIL_TITLE);
    }

    /**
     * @param string $message
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModelPendingEmailMessage($message): void
    {
        $this->setSetting(SettingKey::MODEL_PENDING_EMAIL_MESSAGE, $message);
    }

    /**
     * @return string
     */
    public function getModelPendingEmailMessage(): string
    {
        return (string)$this->getSetting(SettingKey::MODEL_PENDING_EMAIL_MESSAGE);
    }

    /**
     * @param int $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModelDeclinedNotification($enable): void
    {
        $this->setSetting(SettingKey::MODEL_DECLINED_NOTIFICATION, (int)$enable);
    }

    /**
     * @return bool
     */
    public function modelDeclinedNotification(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::MODEL_DECLINED_NOTIFICATION));
    }

    /**
     * @param string $title
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModelDeclinedEmailTitle($title): void
    {
        $this->setSetting(SettingKey::MODEL_DECLINED_EMAIL_TITLE, $title);
    }

    /**
     * @return string
     */
    public function getModelDeclinedEmailTitle(): string
    {
        return (string)$this->getSetting(SettingKey::MODEL_DECLINED_EMAIL_TITLE);
    }

    /**
     * @param string $message
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setModelDeclinedEmailMessage($message): void
    {
        $this->setSetting(SettingKey::MODEL_DECLINED_EMAIL_MESSAGE, $message);
    }

    /**
     * @return string
     */
    public function getModelDeclinedEmailMessage(): string
    {
        return (string)$this->getSetting(SettingKey::MODEL_DECLINED_EMAIL_MESSAGE);
    }

    /**
     * @param int $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAdminModelPendingNotification($enable): void
    {
        $this->setSetting(SettingKey::ADMIN_MODEL_PENDING_NOTIFICATION, (int)$enable);
    }

    /**
     * @return bool
     */
    public function adminModelPendingNotification(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ADMIN_MODEL_PENDING_NOTIFICATION));
    }

    /**
     * @param string $title
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAdminModelPendingEmailTitle($title): void
    {
        $this->setSetting(SettingKey::ADMIN_MODEL_PENDING_EMAIL_TITLE, $title);
    }

    /**
     * @return string
     */
    public function getAdminModelPendingEmailTitle(): string
    {
        return (string)$this->getSetting(SettingKey::ADMIN_MODEL_PENDING_EMAIL_TITLE);
    }

    /**
     * @param string $message
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAdminModelPendingEmailMessage($message): void
    {
        $this->setSetting(SettingKey::ADMIN_MODEL_PENDING_EMAIL_MESSAGE, $message);
    }

    /**
     * @return string
     */
    public function getAdminModelPendingEmailMessage(): string
    {
        return (string)$this->getSetting(SettingKey::ADMIN_MODEL_PENDING_EMAIL_MESSAGE);
    }

    /**
     * @param int $enable
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setWelcomeUserNotification($enable): void
    {
        $this->setSetting(SettingKey::WELCOME_USER_NOTIFICATION, (int)$enable);
    }

    /**
     * @return bool
     */
    public function welcomeUserNotification(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::WELCOME_USER_NOTIFICATION));
    }

    /**
     * @param string $title
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setWelcomeUserEmailTitle($title): void
    {
        $this->setSetting(SettingKey::WELCOME_USER_EMAIL_TITLE, $title);
    }

    /**
     * @return string
     */
    public function getWelcomeUserEmailTitle(): string
    {
        return (string)$this->getSetting(SettingKey::WELCOME_USER_EMAIL_TITLE);
    }

    /**
     * @param string $message
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setWelcomeUserEmailMessage($message): void
    {
        $this->setSetting(SettingKey::WELCOME_USER_EMAIL_MESSAGE, $message);
    }

    /**
     * @return string
     */
    public function getWelcomeUserEmailMessage(): string
    {
        return (string)$this->getSetting(SettingKey::WELCOME_USER_EMAIL_MESSAGE);
    }

    /**
     * @param string $title
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setResetPasswordEmailTitle($title): void
    {
        $this->setSetting(SettingKey::RESET_PASSWORD_EMAIL_TITLE, $title);
    }

    /**
     * @return string
     */
    public function getResetPasswordEmailTitle(): string
    {
        return (string)$this->getSetting(SettingKey::RESET_PASSWORD_EMAIL_TITLE);
    }

    /**
     * @param string $message
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setResetPasswordEmailMessage($message): void
    {
        $this->setSetting(SettingKey::RESET_PASSWORD_EMAIL_MESSAGE, $message);
    }

    /**
     * @return string
     */
    public function getResetPasswordEmailMessage(): string
    {
        return (string)$this->getSetting(SettingKey::RESET_PASSWORD_EMAIL_MESSAGE);
    }

    /**
     * @param string $title
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setUserConfirmationEmailTitle($title): void
    {
        $this->setSetting(SettingKey::USER_CONFIRMATION_EMAIL_TITLE, $title);
    }

    /**
     * @return string
     */
    public function getUserConfirmationEmailTitle(): string
    {
        return (string)$this->getSetting(SettingKey::USER_CONFIRMATION_EMAIL_TITLE);
    }

    /**
     * @param string $message
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setUserConfirmationEmailMessage($message): void
    {
        $this->setSetting(SettingKey::USER_CONFIRMATION_EMAIL_MESSAGE, $message);
    }

    /**
     * @return string
     */
    public function getUserConfirmationEmailMessage(): string
    {
        return (string)$this->getSetting(SettingKey::USER_CONFIRMATION_EMAIL_MESSAGE);
    }

}