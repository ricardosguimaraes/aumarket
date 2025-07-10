<?php

namespace Tangibledesign\Framework\Models\Notification;

class UserSubscriptionRenewedNotification extends Notification
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
        ];
    }

    public function getHint(): string
    {
        return tdf_admin_string('user_subscription_renewed_notification_hint');
    }

}