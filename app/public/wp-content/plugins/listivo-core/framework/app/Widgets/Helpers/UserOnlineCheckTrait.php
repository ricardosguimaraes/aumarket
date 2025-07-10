<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

use Tangibledesign\Framework\Models\User\User;

trait UserOnlineCheckTrait
{
    public function isUserOnline(int $minutesLimit): bool
    {
        $user = $this->getUser();
        if (!$user) {
            return false;
        }

        if (empty($minutesLimit)) {
            return apply_filters('myhome/user/isOnline', false, $user);
        }

        return apply_filters('myhome/user/isOnline', $user->wasActiveInLastMinutes($minutesLimit), $user);
    }

    abstract public function getUser(): ?User;
}