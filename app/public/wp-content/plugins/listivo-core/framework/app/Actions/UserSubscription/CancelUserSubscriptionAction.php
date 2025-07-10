<?php

namespace Tangibledesign\Framework\Actions\UserSubscription;

use Stripe\Exception\ApiErrorException;
use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Models\User\User;

class CancelUserSubscriptionAction
{
    public function execute(UserSubscription $userSubscription, bool $suppressNotifications = false): bool
    {
        $method = $userSubscription->getMeta('method');

        if (($method === 'stripe') && $this->cancelStripe($userSubscription)) {
            return $this->cancel($userSubscription, $suppressNotifications);
        }

        if ($method === 'free') {
            return $this->cancel($userSubscription, $suppressNotifications);
        }

        return false;
    }

    private function cancel(UserSubscription $userSubscription, bool $suppressNotifications = false): bool
    {
        $userSubscription->setMeta('status', 'canceled');
        $userSubscription->setMeta('canceled_at', date('Y-m-d H:i:s'));

        $user = $userSubscription->getUser();
        if (!$user instanceof User) {
            return false;
        }

        if (tdf_settings()->getSubscriptionRenewalPolicy() === SettingKey::SUBSCRIPTION_RENEWAL_POLICY_RESET) {
            $userSubscription->applyExpireDateToPackages();
        }

        $user->setUserSubscription(0);

        if (!$suppressNotifications) {
            do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_SUBSCRIPTION_CANCELLED, [
                'user' => $user->getId(),
            ]);

            do_action('tdf/userSubscription/cancelled', $user, $userSubscription);
        }

        return true;
    }

    private function cancelStripe(UserSubscription $userSubscription): bool
    {
        $stripeSubscriptionId = $userSubscription->getMeta('stripe_subscription_id');
        if (empty($stripeSubscriptionId)) {
            return false;
        }

        try {
            tdf_stripe()->subscriptions->cancel($stripeSubscriptionId, []);
        } catch (ApiErrorException $e) {
            return false;
        }

        return true;
    }
}