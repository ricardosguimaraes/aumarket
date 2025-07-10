<?php

namespace Tangibledesign\Framework\Actions\Users\Verify\Twilio;

use Tangibledesign\Framework\Models\User\User;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class SendVerificationTokenAction
{

    public function execute(User $user): bool
    {
        if (!$user->hasPhone()) {
            return false;
        }

        $client = tdf_app('twilio_client');
        if (!$client instanceof Client) {
            return false;
        }

        try {
            $client->verify->v2->services(tdf_settings()->getTwilioVerifyServiceSid())
                ->verifications
                ->create($user->getPhoneWithCountryCode(), 'sms');
        } catch (TwilioException $e) {
            return false;
        }

        return true;
    }

}