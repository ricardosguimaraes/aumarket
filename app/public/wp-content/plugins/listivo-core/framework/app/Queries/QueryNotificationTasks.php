<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;
use Tangibledesign\Framework\Models\Notification\Tasks\NotificationTask;

class QueryNotificationTasks extends QueryPosts
{
    /** @var string */
    protected string $postType = 'notify_task';

    /** @var bool */
    protected bool $prefixPostType = true;

    public function waiting(): QueryNotificationTasks
    {
        return $this->taskStatus(NotificationTask::STATUS_WAITING);
    }

    public function taskStatus(string $status): QueryNotificationTasks
    {
        $this->metaQuery[] = [
            'key' => NotificationTask::STATUS,
            'value' => $status,
        ];

        return $this;
    }

    protected function getFactory(): BasePostFactory
    {
        return tdf_notification_task_factory();
    }

}