<?php

namespace Tangibledesign\Framework\Models\Notification;

class NotificationType
{
    public const MAIL = 'mail';
    public const TWILIO_SMS = 'twilio_sms';

    public static function getListWithNames(): array
    {
        return [
            self::MAIL => tdf_admin_string('email'),
            self::TWILIO_SMS => tdf_admin_string('sms_twilio'),
        ];
    }

    public static function getDisplayName(string $status): string
    {
        $list = self::getListWithNames();

        return $list[$status] ?? '';
    }
}