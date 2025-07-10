<?php

namespace Tangibledesign\Framework\Models\Notification;

class UserWelcomeNotification extends Notification
{
    /**
     * @return string[]
     */
    public function getAllowedTags(): array
    {
        return [
            'userDisplayName',
            'userDisplayNameWithLink',
            'userFirstName',
            'userLastName',
            'userMail',
            'userUrl',
        ];
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return tdf_admin_string('user_welcome_notification_hint');
    }

}