<?php

namespace Tangibledesign\Framework\Models\Notification;

class UserNewMessageNotification extends Notification
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
            'messageReplyUrl',
            'messageSenderDisplayName',
            'messageSenderDisplayNameWithUrl',
            'messageSenderUrl',
            'messageText',
        ];
    }

    /**
     * @return string
     */
    public function getHint(): string
    {
        return tdf_admin_string('user_new_message_notification_hint');
    }

}