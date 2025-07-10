<?php

namespace Tangibledesign\Framework\Models\Notification;

class ModelApprovedNotification extends Notification
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
            'adUrl',
        ];
    }

    public function getHint(): string
    {
        return tdf_admin_string('model_approved_notification_hint');
    }

}