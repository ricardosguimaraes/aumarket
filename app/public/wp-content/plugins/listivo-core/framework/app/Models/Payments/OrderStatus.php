<?php

namespace Tangibledesign\Framework\Models\Payments;

class OrderStatus
{
    public const PENDING = 'pending';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';
    public const REFUNDED = 'refunded';
    public const FAILED = 'failed';
    public const ON_HOLD = 'on-hold';
    public const PROCESSING = 'processing';

    public static function all(): array
    {
        return [
            self::ON_HOLD,
            self::PENDING,
            self::PROCESSING,
            self::COMPLETED,
            self::CANCELLED,
            self::REFUNDED,
            self::FAILED,
        ];
    }

}