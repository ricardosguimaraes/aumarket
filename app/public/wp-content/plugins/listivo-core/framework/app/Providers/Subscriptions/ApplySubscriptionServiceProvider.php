<?php

namespace Tangibledesign\Framework\Providers\Subscriptions;

use Stripe\Invoice;
use Tangibledesign\Framework\Actions\PaymentPackage\ApplyPackageToModelInProgressAction;
use Tangibledesign\Framework\Actions\UserSubscription\RenewFreeUserSubscriptions;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Payments\PaymentPackageInterface;
use Tangibledesign\Framework\Models\Payments\UserPaymentPackageInterface;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Models\User\User;

class ApplySubscriptionServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('tdf/subscriptions/apply', [$this, 'apply']);

        add_action('tdf/stripe/invoice/paid', [$this, 'applySubscriptionFromStripe']);

        add_action('admin_init', static function () {
            if (!wp_next_scheduled(tdf_prefix() . '/subscriptions/free/renew')) {
                wp_schedule_event(time(), 'daily', tdf_prefix() . '/subscriptions/free/renew');
            }
        });

        add_action(tdf_prefix() . '/subscriptions/free/renew', static function () {
            (new RenewFreeUserSubscriptions())->execute();
        });
    }

    public function applySubscriptionFromStripe(Invoice $invoice): void
    {
        if ($invoice->billing_reason === 'subscription_create') {
            return;
        }

        $userSubscription = tdf_query_user_subscriptions()
            ->where('stripe_subscription_id', $invoice->subscription)
            ->first();

        if (!$userSubscription instanceof UserSubscription) {
            return;
        }

        $userSubscription->setCurrentPeriodStart($invoice->period_start);
        $userSubscription->setCurrentPeriodEnd($invoice->period_end);

        $this->apply($userSubscription);

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_SUBSCRIPTION_RENEWED, [
            'user' => $userSubscription->getUserId(),
        ]);
    }

    public function apply(UserSubscription $userSubscription): void
    {
        $user = $userSubscription->getUser();
        if (!$user instanceof User) {
            return;
        }

        $subscription = $userSubscription->getSubscription();
        if (!$subscription instanceof PaymentPackageInterface) {
            return;
        }

        /* @var UserSubscription $userSubscription */
        if (tdf_settings()->getSubscriptionRenewalPolicy() === SettingKey::SUBSCRIPTION_RENEWAL_POLICY_RESET) {
            $userSubscription->deletePackages();
        }

        $userPaymentPackage = $user->addPaymentPackage($subscription);
        if (!$userPaymentPackage instanceof UserPaymentPackageInterface) {
            return;
        }

        do_action(tdf_prefix() . '/user/subscription/applied', $userPaymentPackage, $userSubscription, $user);

        if (!$user->hasModelInProgress()) {
            return;
        }

        $model = $user->getModelInProgress();
        if (!$model instanceof Model) {
            return;
        }

        (new ApplyPackageToModelInProgressAction())->execute($model, $userPaymentPackage);
    }
}