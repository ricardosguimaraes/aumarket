<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetTwilioCredentials
{
    use Setting;

    /**
     * @param  string  $twilioAccountSid
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setTwilioAccountSid($twilioAccountSid): void
    {
        $this->setSetting(SettingKey::TWILIO_ACCOUNT_SID, (string)$twilioAccountSid);
    }

    /**
     * @return string
     */
    public function getTwilioAccountSid(): string
    {
        return (string)$this->getSetting(SettingKey::TWILIO_ACCOUNT_SID);
    }

    /**
     * @param  string  $twilioAuthToken
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setTwilioAuthToken($twilioAuthToken): void
    {
        $this->setSetting(SettingKey::TWILIO_AUTH_TOKEN, $twilioAuthToken);
    }

    /**
     * @return string
     */
    public function getTwilioAuthToken(): string
    {
        return (string)$this->getSetting(SettingKey::TWILIO_AUTH_TOKEN);
    }

    /**
     * @param  string  $twilioPhoneNumber
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setTwilioPhoneNumber($twilioPhoneNumber): void
    {
        $this->setSetting(SettingKey::TWILIO_PHONE_NUMBER, $twilioPhoneNumber);
    }

    /**
     * @return string
     */
    public function getTwilioPhoneNumber(): string
    {
        return (string)$this->getSetting(SettingKey::TWILIO_PHONE_NUMBER);
    }

    /**
     * @param  string  $twilioVerifyServiceSid
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setTwilioVerifyServiceSid($twilioVerifyServiceSid): void
    {
        $this->setSetting(SettingKey::TWILIO_VERIFY_SERVICE_SID, $twilioVerifyServiceSid);
    }

    /**
     * @return string
     */
    public function getTwilioVerifyServiceSid(): string
    {
        return (string)$this->getSetting(SettingKey::TWILIO_VERIFY_SERVICE_SID);
    }

}