<?php

namespace Tangibledesign\Framework\Actions\UserSubscription;

use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Traits\UserSubscription\HasFreeUserSubscriptionPeriodsTrait;

class CreateFreeUserSubscriptionAction
{
    use HasFreeUserSubscriptionPeriodsTrait;

    public function execute(User $user, bool $silent = false): int
    {
        $currentPeriodStart = $this->geCurrentPeriodStart();

        $id = wp_insert_post([
            'post_title' => 'New User Subscription',
            'post_type' => tdf_prefix().'_user_subs',
            'post_status' => 'publish',
            'meta_input' => [
                'subscription' => 'free',
                'user' => $user->getId(),
                'current_period_start' => $currentPeriodStart,
                'current_period_end' => $this->getCurrentPeriodEnd($currentPeriodStart),
                'start_date' => $currentPeriodStart,
                'status' => 'active',
                'method' => 'free',
            ],
        ]);

        if (is_wp_error($id)) {
            return 0;
        }

        $user->setUserSubscription($id);

        if (!$silent) {
            $userSubscription = tdf_user_subscription_factory()->create($id);
            if ($userSubscription instanceof UserSubscription) {
                do_action('tdf/subscriptions/apply', $userSubscription);
            }

            do_action(tdf_prefix().'/notifications/trigger', Trigger::USER_SUBSCRIPTION_STARTED, [
                'user' => $user->getId(),
            ]);
        }

        return $id;
    }
}