<?php

namespace Tangibledesign\Framework\Providers\Stripe;

use Stripe\StripeClient;
use Tangibledesign\Framework\Core\ServiceProvider;

class StripeServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['stripe'] = static function () {
            return new StripeClient(tdf_settings()->getStripeSecretKey());
        };
    }
}