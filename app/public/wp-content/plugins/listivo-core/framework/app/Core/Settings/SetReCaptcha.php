<?php


namespace Tangibledesign\Framework\Core\Settings;


/**
 * Trait SetReCaptcha
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetReCaptcha
{
    use Setting;

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setReCaptcha($enabled): void
    {
        $this->setSetting(SettingKey::RE_CAPTCHA, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function isRecaptchaChecked(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::RE_CAPTCHA));
    }

    /**
     * @return bool
     */
    public function reCaptchaEnabled(): bool
    {
        return $this->isRecaptchaChecked()
            && !empty($this->getReCaptchaSiteKey())
            && !empty($this->getReCaptchaSecretKey());
    }

    /**
     * @param string $siteKey
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setReCaptchaSiteKey($siteKey): void
    {
        $this->setSetting(SettingKey::RE_CAPTCHA_SITE_KEY, $siteKey);
    }

    /**
     * @return string
     */
    public function getReCaptchaSiteKey(): string
    {
        return (string)$this->getSetting(SettingKey::RE_CAPTCHA_SITE_KEY);
    }

    /**
     * @param string $secretKey
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setReCaptchaSecretKey($secretKey): void
    {
        $this->setSetting(SettingKey::RE_CAPTCHA_SECRET_KEY, $secretKey);
    }

    /**
     * @return string
     */
    public function getReCaptchaSecretKey(): string
    {
        return (string)$this->getSetting(SettingKey::RE_CAPTCHA_SECRET_KEY);
    }

}