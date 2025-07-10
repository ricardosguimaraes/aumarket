<?php

namespace Tangibledesign\Framework\Actions\UserSubscription;

use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Payments\StripeOrder;
use Tangibledesign\Framework\Models\Payments\Subscription;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Models\User\User;

class CreateUserSubscriptionFromStripeSessionAction
{
    public function execute(Session $session): int
    {
        if (empty($session->subscription) || empty($session->customer)) {
            return 0;
        }
        
        $stripeSubscription = $this->fetchStripeSubscription($session->subscription);
        if (!$stripeSubscription instanceof \Stripe\Subscription) {
            return 0;
        }

        $user = $this->fetchUserByStripeCustomerId($session->customer);
        if (!$user instanceof User) {
            return 0;
        }

        if ($user->hasUserSubscription()) {
            $this->handleCurrentSubscription($user);
        }

        $id = wp_insert_post([
            'post_title' => 'New User Subscription',
            'post_type' => tdf_prefix() . '_user_subs',
            'post_status' => 'publish',
            'meta_input' => [
                'stripe_session_id' => $session->id,
                'stripe_customer_id' => $session->customer,
                'stripe_subscription_id' => $stripeSubscription->id,
                'subscription' => $this->getSubscriptionId($stripeSubscription->plan->product),
                'user' => $user->getId(),
                'current_period_start' => $stripeSubscription->current_period_start,
                'current_period_end' => $stripeSubscription->current_period_end,
                'start_date' => $stripeSubscription->start_date,
                'default_payment_method' => $stripeSubscription->default_payment_method,
                'status' => 'active',
                'method' => 'stripe',
            ],
        ]);

        if (is_wp_error($id)) {
            return 0;
        }

        $user->setUserSubscription($id);

        $userSubscription = tdf_user_subscription_factory()->create($id);
        if ($userSubscription instanceof UserSubscription) {
            do_action('tdf/subscriptions/apply', $userSubscription);

            $this->updateOrderByStripeSubscriptionId($userSubscription, $stripeSubscription->id);
        }

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_SUBSCRIPTION_STARTED, [
            'user' => $user->getId(),
        ]);

        return $id;
    }

    private function handleCurrentSubscription(User $user): void
    {
        $userSubscription = $user->getUserSubscription();
        if (!$userSubscription instanceof UserSubscription) {
            return;
        }

        do_action('tdf/userSubscription/cancel', $userSubscription, true);
    }

    private function fetchUserByStripeCustomerId(string $stripeCustomerId): ?User
    {
        return tdf_query_users()->whereStripeCustomerId($stripeCustomerId)->get()->first();
    }

    private function fetchStripeSubscription(string $stripeSubscriptionId): ?\Stripe\Subscription
    {
        try {
            $stripeSubscription = tdf_stripe()->subscriptions->retrieve($stripeSubscriptionId, []);
        } catch (ApiErrorException $e) {
            return null;
        }

        return $stripeSubscription ?? null;
    }

    private function getSubscriptionId(string $stripeProductId): int
    {
        $subscriptionId = tdf_subscriptions()->find(static function ($subscription) use ($stripeProductId) {
            /* @var Subscription $subscription */
            return $subscription->getStripeProductId() === $stripeProductId;
        });

        if (!$subscriptionId instanceof Subscription) {
            return 0;
        }

        return $subscriptionId->getId();
    }

    private function updateOrderByStripeSubscriptionId(
        UserSubscription $userSubscription,
        string           $stripeSubscriptionId
    ): void
    {
        $order = tdf_query_orders()->where('stripe_subscription_id', $stripeSubscriptionId)->get()->first();
        if (!$order instanceof StripeOrder) {
            return;
        }

        $order->setMeta('user_subscription', $userSubscription->getId());
    }
}