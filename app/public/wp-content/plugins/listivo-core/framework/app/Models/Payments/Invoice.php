<?php

namespace Tangibledesign\Framework\Models\Payments;

use DateTime;
use Exception;
use Tangibledesign\Framework\Models\Post\PostModel;

class Invoice extends PostModel
{

    public function getNumber(): string
    {
        return (string)$this->getMeta('number');
    }

    public function getPdf(): string
    {
        return (string)$this->getMeta('pdf');
    }

    public function getTotal()
    {
        return $this->getMeta('total');
    }

    public function getCurrency(): string
    {
        return (string)$this->getMeta('currency');
    }

    public function setUserSubscription(int $userSubscriptionId): void
    {
        $this->setMeta('user_subscription', $userSubscriptionId);
    }

    private function getUserSubscriptionId(): int
    {
        return (int)$this->getMeta('user_subscription');
    }

    public function getUserSubscription(): ?UserSubscription
    {
        $userSubscriptionId = $this->getUserSubscriptionId();
        if (empty($userSubscriptionId)) {
            return null;
        }

        return tdf_user_subscription_factory()->create($userSubscriptionId);
    }

    public function getCurrentPeriodStart(): ?DateTime
    {
        $currentPeriodStart = $this->getMeta('current_period_start');
        if (empty($currentPeriodStart)) {
            return null;
        }

        try {
            return new DateTime(date('Y-m-d H:i:s', $currentPeriodStart));
        } catch (Exception $e) {
            return null;
        }
    }

    public function getCurrentPeriodEnd(): ?DateTime
    {
        $currentPeriodEnd = $this->getMeta('current_period_end');
        if (empty($currentPeriodEnd)) {
            return null;
        }

        try {
            return new DateTime(date('Y-m-d H:i:s', $currentPeriodEnd));
        } catch (Exception $e) {
            return null;
        }
    }

    public function getStripeSubscriptionId(): string
    {
        return (string)$this->getMeta('stripe_subscription_id');
    }

}