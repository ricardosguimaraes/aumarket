<?php

namespace Tangibledesign\Framework\Models\Notification;

class ModelDeclinedNotification extends Notification
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
            'declineReason',
        ];
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return tdf_admin_string('model_declined_notification_hint');
    }

}