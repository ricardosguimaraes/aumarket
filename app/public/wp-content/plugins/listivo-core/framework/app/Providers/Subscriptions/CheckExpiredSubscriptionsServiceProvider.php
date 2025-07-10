<?php

namespace Tangibledesign\Framework\Providers\Subscriptions;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Payments\UserSubscription;

class CheckExpiredSubscriptionsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('tdf/subscriptions/checkExpired', [$this, 'checkExpiredSubscriptions']);

        add_action('admin_init', [$this, 'scheduleCheckExpiredSubscriptions']);
    }

    public function scheduleCheckExpiredSubscriptions(): void
    {
        if (!wp_next_scheduled('tdf/subscriptions/checkExpired')) {
            wp_schedule_event(time(), 'daily', 'tdf/subscriptions/checkExpired');
        }
    }

    public function checkExpiredSubscriptions(): void
    {
        tdf_query_user_subscriptions()
            ->expired()
            ->get()
            ->each(function (UserSubscription $userSubscription) {
                if (tdf_settings()->getSubscriptionRenewalPolicy() === SettingKey::SUBSCRIPTION_RENEWAL_POLICY_RESET) {
                    $userSubscription->deletePackages();
                }

                $userSubscription->setStatus('expired');

                do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_SUBSCRIPTION_EXPIRED, [
                    'user' => $userSubscription->getUserId(),
                ]);
            });
    }
}