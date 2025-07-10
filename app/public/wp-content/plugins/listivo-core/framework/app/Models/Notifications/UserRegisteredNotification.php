<?php

namespace Tangibledesign\Framework\Models\Notification;

class UserRegisteredNotification extends Notification
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
            'userUrl',
            'userMail',
            'userPhone',
            'userAccountType',
            'userCompanyInformation',
        ];
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return tdf_admin_string('user_registered_notification_hint');
    }

}