<?php

namespace Tangibledesign\Framework\Models\Notification;

class ModerationReviewPendingNotification extends Notification
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
            'reviewText',
        ];
    }

    public function getHint(): string
    {
        return tdf_admin_string('moderation_review_pending_notification_hint');
    }
}