<?php

namespace Tangibledesign\Framework\Providers\Subscriptions;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\UserSubscription;

class DeleteUserSubscriptionServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_tdf/userSubscription/delete', [$this, 'delete']);
    }

    public function delete(): void
    {
        if (!current_user_can('manage_options')) {
            $this->errorJsonResponse();
            return;
        }

        $userSubscriptionId = (int)$_POST['userSubscriptionId'];
        if (!$userSubscriptionId) {
            $this->errorJsonResponse();
            return;
        }

        $userSubscription = tdf_user_subscription_factory()->create($userSubscriptionId);
        if (!$userSubscription) {
            $this->errorJsonResponse();
            return;
        }

        $userSubscription->delete(UserSubscription::SUPPRESS_NOTIFICATIONS);

        $this->successJsonResponse();
    }
}