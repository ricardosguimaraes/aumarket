<?php

namespace Tangibledesign\Framework\Models\Notification;

class SendToGroups
{
    public const ADMINS = 'admins';
    public const MODERATORS = 'moderators';

    /**
     * @return array
     */
    public static function getListWithNames(): array
    {
        return [
            self::ADMINS => tdf_admin_string('admins'),
            self::MODERATORS => tdf_admin_string('moderators'),
        ];
    }

}