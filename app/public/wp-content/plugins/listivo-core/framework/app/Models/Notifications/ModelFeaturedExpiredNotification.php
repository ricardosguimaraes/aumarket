<?php

namespace Tangibledesign\Framework\Models\Notification;

class ModelFeaturedExpiredNotification extends Notification
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
            'userCompanyInformation',
            'adName',
            'adUrl',
        ];
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return tdf_admin_string('model_featured_expired_notification_hint');
    }

}