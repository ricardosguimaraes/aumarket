<?php

namespace Tangibledesign\Framework\Traits\UserSubscription;

use DateInterval;
use DateTime;

trait HasFreeUserSubscriptionPeriodsTrait
{

    protected function geCurrentPeriodStart(): int
    {
        return time();
    }

    protected function getCurrentPeriodEnd(int $currentPeriodStart): int
    {
        $date = new DateTime();
        $date->setTimestamp($currentPeriodStart);
        $date->add(new DateInterval('P30D'));

        return $date->getTimestamp();
    }

}