<?php

namespace Tangibledesign\Framework\Actions\Notifications;

use Tangibledesign\Framework\Models\Notification\ModelExpireNotification;
use Tangibledesign\Framework\Models\Notification\Notification;
use Tangibledesign\Framework\Models\Notification\NotificationType;

class UpdateNotificationAction
{
    /**
     * @param  int  $notificationId
     * @param  array  $notificationData
     * @return void
     */
    public function execute(int $notificationId, array $notificationData): void
    {
        $notification = tdf_notification_factory()->create($notificationId);
        if (empty($notification)) {
            return;
        }

        $notification->setName($notificationData[Notification::NAME] ?? '');

        $types = $notificationData[Notification::TYPES] ?? [];

        $notification->setTypes($types);

        if (in_array(NotificationType::MAIL, $types, true)) {
            $notification->setMailTitle($notificationData[Notification::MAIL_TITLE] ?? '');

            $notification->setMailText($notificationData[Notification::MAIL_TEXT] ?? '');
        }

        if (in_array(NotificationType::TWILIO_SMS, $types, true)) {
            $notification->setSmsText($notificationData[Notification::SMS_TEXT] ?? '');
        }

        if ($notification->sendToGroup()) {
            $notification->setSendToGroups($notificationData[Notification::SEND_TO_GROUPS] ?? []);
        }

        if ($notification instanceof ModelExpireNotification) {
            $notification->setHours((int) ($notificationData[ModelExpireNotification::HOURS] ?? 0));
        }
    }

}