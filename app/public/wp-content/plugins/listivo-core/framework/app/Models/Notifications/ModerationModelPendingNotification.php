<?php

namespace Tangibledesign\Framework\Models\Notification;

class ModerationModelPendingNotification extends Notification
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
        return tdf_admin_string('moderation_model_pending_notification_hint');
    }
}