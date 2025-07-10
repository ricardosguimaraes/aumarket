<?php

namespace Tangibledesign\Framework\Actions\Notifications;

use Tangibledesign\Framework\Models\Notification\Notification;
use Tangibledesign\Framework\Models\Post\PostStatus;

class CreateNotificationAction
{
    /**
     * @param  array  $notificationData
     * @return int|false
     */
    public function execute(array $notificationData)
    {
        $id = wp_insert_post([
            'post_title' => $notificationData[Notification::NAME] ?? '',
            'post_type' => tdf_prefix().'_notify',
            'post_status' => PostStatus::PUBLISH,
            'meta_input' => [
                Notification::TYPES => $notificationData[Notification::TYPES] ?? [],
                Notification::TRIGGER => $notificationData[Notification::TRIGGER] ?? '',
            ]
        ]);

        if (is_wp_error($id)) {
            return false;
        }

        return $id;
    }

}