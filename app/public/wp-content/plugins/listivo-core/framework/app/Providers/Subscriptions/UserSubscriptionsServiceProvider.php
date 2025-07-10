<?php

namespace Tangibledesign\Framework\Providers\Subscriptions;

use Stripe\Checkout\Session;
use Stripe\Invoice;
use Tangibledesign\Framework\Actions\UserSubscription\CancelUserSubscriptionAction;
use Tangibledesign\Framework\Actions\UserSubscription\CreateUserSubscriptionFromStripeSessionAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Payments\Order;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Models\User\User;

class UserSubscriptionsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('tdf/stripe/checkout/session/completed', [$this, 'createFromStripeSession']);

        add_action('tdf/userSubscription/cancel', [$this, 'cancelUserSubscription'], 10, 2);

        add_action('tdf/userSubscription/cancelCurrentUser', [$this, 'cancelCurrentUserSubscription']);

        add_action('admin_post_tdf/userSubscription/cancelCurrentUser', [$this, 'cancelCurrentUserSubscription']);

        add_action('tdf/stripe/invoice/payment_failed', [$this, 'paymentFailed']);

        add_action('delete_user', [$this, 'deleteUserSubscription']);
    }

    public function deleteUserSubscription($userId): void
    {
        $user = tdf_user_factory()->create($userId);
        if (!$user instanceof User) {
            return;
        }

        $userSubscription = $user->getUserSubscription();
        if (!$userSubscription instanceof UserSubscription) {
            return;
        }

        $userSubscription->delete();
    }

    public function paymentFailed(Invoice $invoice): void
    {
        if (empty($invoice->customer)) {
            return;
        }

        $user = tdf_query_users()
            ->whereStripeCustomerId($invoice->customer)
            ->get()
            ->first();

        if (!$user instanceof User) {
            return;
        }

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_SUBSCRIPTION_PAYMENT_FAILED, [
            'user' => $user->getId(),
        ]);
    }

    public function cancelCurrentUserSubscription(bool $suppressNotifications = false): void
    {
        $user = tdf_current_user();
        if (!$user instanceof User) {
            $this->errorJsonResponse();
            return;
        }

        $userSubscription = $user->getUserSubscription();
        if (!$userSubscription instanceof UserSubscription) {
            $this->errorJsonResponse();
            return;
        }

        $this->cancelUserSubscription($userSubscription, $suppressNotifications);

        $this->successJsonResponse();
    }

    public function cancelUserSubscription(UserSubscription $userSubscription, bool $suppressNotifications = false): void
    {
        (new CancelUserSubscriptionAction())->execute($userSubscription, $suppressNotifications);
    }

    public function createFromStripeSession(Session $session): void
    {
        if ($session->status !== 'complete' && $session->payment_status !== 'paid') {
            return;
        }

        $userSubscriptionId = (new CreateUserSubscriptionFromStripeSessionAction())->execute($session);
        if (empty($userSubscriptionId)) {
            return;
        }

        $userSubscription = tdf_user_factory()->create($userSubscriptionId);
        if (!$userSubscription instanceof UserSubscription) {
            return;
        }

        tdf_query_orders()
            ->where('stripe_subscription_id', $session->subscription)
            ->get()
            ->each(function ($order) use ($userSubscription) {
                /* @var $order Order */
                $order->setMeta('user_subscription', $userSubscription->getId());
                $order->setUser($userSubscription->getUserId());
            });
    }
}