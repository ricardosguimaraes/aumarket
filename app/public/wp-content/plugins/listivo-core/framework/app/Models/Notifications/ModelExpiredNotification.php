<?php

namespace Tangibledesign\Framework\Models\Notification;

class ModelExpiredNotification extends Notification
{
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

    public function getHint(): string
    {
        return tdf_admin_string('model_expired_notification_hint');
    }
}