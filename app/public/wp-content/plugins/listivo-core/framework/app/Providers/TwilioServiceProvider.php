<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Twilio\Rest\Client;

class TwilioServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['twilio_client'] = static function () {
            if (empty(tdf_settings()->getTwilioAccountSid()) || empty(tdf_settings()->getTwilioAuthToken())) {
                return false;
            }

            return new Client(tdf_settings()->getTwilioAccountSid(), tdf_settings()->getTwilioAuthToken());
        };
    }

}