<?php

namespace Tangibledesign\Framework\Actions\Users\Verify\Twilio;

use Tangibledesign\Framework\Models\User\User;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use Twilio\Rest\Verify\V2\Service\VerificationCheckInstance;

class CheckVerificationTokenAction
{
    /**
     * @param  User  $user
     * @param  string  $token
     * @return bool
     */
    public function execute(User $user, string $token): bool
    {
        if (!$user->hasPhone()) {
            return false;
        }

        $client = tdf_app('twilio_client');
        if (!$client instanceof Client) {
            return false;
        }

        try {
            /* @var VerificationCheckInstance $verificationCheck */
            $verificationCheck = $client->verify->v2->services(tdf_settings()->getTwilioVerifyServiceSid())
                ->verificationChecks
                ->create([
                        "to" => $user->getPhoneWithCountryCode(),
                        "code" => $token
                    ]
                );
        } catch (TwilioException $e) {
            return false;
        }

        return $verificationCheck->status === 'approved';
    }

}