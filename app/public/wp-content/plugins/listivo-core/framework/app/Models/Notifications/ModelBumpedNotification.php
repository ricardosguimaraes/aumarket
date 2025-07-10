<?php

namespace Tangibledesign\Framework\Models\Notification;

class ModelBumpedNotification extends Notification
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
            'adUrl',
        ];
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return tdf_admin_string('model_bumped_notification_hint');
    }


}