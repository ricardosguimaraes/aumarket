<?php

namespace Tangibledesign\Framework\Actions\UserSubscription;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Traits\UserSubscription\HasFreeUserSubscriptionPeriodsTrait;

class RenewFreeUserSubscriptions
{
    use HasFreeUserSubscriptionPeriodsTrait;

    public function execute(): void
    {
        $currentPeriodStart = $this->geCurrentPeriodStart();
        $currentPeriodEnd = $this->getCurrentPeriodEnd($currentPeriodStart);

        foreach ($this->getSubscriptions() as $userSubscription) {
            do_action('tdf/subscriptions/apply', $userSubscription);

            $userSubscription->setMetas([
                'current_period_start' => $currentPeriodStart,
                'current_period_end' => $currentPeriodEnd,
            ]);
        }
    }

    private function getSubscriptions(): Collection
    {
        return tdf_query_user_subscriptions()
            ->where('current_period_end', time(), '<')
            ->get()
            ->filter(static function ($userSubscription) {
                return $userSubscription instanceof UserSubscription;
            });
    }

}