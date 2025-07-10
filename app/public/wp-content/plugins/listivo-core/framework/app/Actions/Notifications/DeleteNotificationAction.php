<?php

namespace Tangibledesign\Framework\Actions\Notifications;

use Tangibledesign\Framework\Models\Notification\Notification;

class DeleteNotificationAction
{
    /**
     * @param  int  $notificationId
     * @return void
     */
    public function execute(int $notificationId): void
    {

        $notification = tdf_notification_factory()->create($notificationId);
        if (!$notification instanceof Notification) {
            return;
        }

        wp_delete_post($notification->getId(), true);
    }

}