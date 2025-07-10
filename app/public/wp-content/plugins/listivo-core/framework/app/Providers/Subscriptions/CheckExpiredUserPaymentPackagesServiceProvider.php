<?php

namespace Tangibledesign\Framework\Providers\Subscriptions;

use Tangibledesign\Framework\Core\ServiceProvider;

class CheckExpiredUserPaymentPackagesServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_init', static function () {
            if (!wp_next_scheduled('tdf/subscriptions/checkExpiredPaymentPackages')) {
                wp_schedule_event(time(), 'hourly', 'tdf/subscriptions/checkExpiredPaymentPackages');
            }
        });

        add_action('tdf/subscriptions/checkExpiredPaymentPackages', [$this, 'checkExpiredPaymentPackages']);
    }

    public function checkExpiredPaymentPackages(): void
    {
        tdf_query_user_payment_packages()
            ->subscriptionSource()
            ->expired()
            ->regularType()
            ->get()
            ->each(function ($userPaymentPackage) {
                $userPaymentPackage->delete();
            });
    }
}