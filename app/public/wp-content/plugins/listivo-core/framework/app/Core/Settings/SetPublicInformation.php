<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetPublicInformation
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetPublicInformation
{
    use Setting;

    /**
     * @param string $email
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setMail($email): void
    {
        $this->setSetting(SettingKey::MAIL, $email);
    }

    /**
     * @return string
     */
    public function getMail(): string
    {
        return (string)$this->getSetting(SettingKey::MAIL);
    }

    /**
     * @param string $phone
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setPhone($phone): void
    {
        $this->setSetting(SettingKey::PHONE, $phone);
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return (string)$this->getSetting(SettingKey::PHONE);
    }

    /**
     * @return string
     */
    public function getPhoneUrl(): string
    {
        return apply_filters(tdf_prefix() . '/phoneUrl', $this->getPhone(), null);
    }

    /**
     * @param string $address
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAddress($address): void
    {
        $this->setSetting(SettingKey::ADDRESS, $address);
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return (string)$this->getSetting(SettingKey::ADDRESS);
    }

}