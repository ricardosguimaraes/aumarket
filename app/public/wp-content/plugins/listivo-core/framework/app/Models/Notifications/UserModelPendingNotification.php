<?php

namespace Tangibledesign\Framework\Models\Notification;

class UserModelPendingNotification extends Notification
{
    /**
     * @return array
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
            'userCompanyInformation',
            'adName',
        ];
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return tdf_admin_string('user_model_pending_notification_hint');
    }

}