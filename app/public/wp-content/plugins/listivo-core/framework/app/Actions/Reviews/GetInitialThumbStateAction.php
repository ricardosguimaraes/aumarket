<?php

namespace Tangibledesign\Framework\Actions\Reviews;

use Tangibledesign\Framework\Models\Review;

class GetInitialThumbStateAction
{
    public static function execute(Review $review): int
    {
        $cookieName = tdf_prefix() . '/review/thumb/' . $review->getId();
        if (!isset($_COOKIE[$cookieName])) {
            return 0;
        }

        $value = (int)$_COOKIE[$cookieName];
        if (!in_array($value, [-1, 0, 1])) {
            return 0;
        }

        return $value;
    }
}