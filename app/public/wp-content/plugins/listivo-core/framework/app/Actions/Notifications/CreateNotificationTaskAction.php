<?php

namespace Tangibledesign\Framework\Actions\Notifications;

use Tangibledesign\Framework\Models\Notification\Tasks\NotificationTask;
use Tangibledesign\Framework\Models\Post\PostStatus;

class CreateNotificationTaskAction
{

    public function execute(string $type, int $userToId, int $notificationId, array $meta = []): void
    {
        wp_insert_post([
            'post_status' => PostStatus::PUBLISH,
            'post_type' => tdf_prefix().'_notify_task',
            'meta_input' => [
                    NotificationTask::USER_TO => $userToId,
                    NotificationTask::TYPE => $type,
                    NotificationTask::NOTIFICATION => $notificationId,
                    NotificationTask::STATUS => NotificationTask::STATUS_WAITING,
                ] + $meta
        ]);
    }

}