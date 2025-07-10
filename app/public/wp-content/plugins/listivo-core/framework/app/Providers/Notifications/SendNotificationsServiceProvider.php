<?php

namespace Tangibledesign\Framework\Providers\Notifications;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Notification\Tasks\NotificationTask;

class SendNotificationsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action(tdf_prefix() . '/notifications/send', [$this, 'handle']);

        add_action('admin_init', function () {
            if (!wp_next_scheduled(tdf_prefix() . '/notifications/send')) {
                wp_schedule_event(time(), 'every_minute', tdf_prefix() . '/notifications/send');
            }
        });
    }

    public function handle(): void
    {
        foreach ($this->getTasks() as $task) {
            $task->execute();
        }
    }

    /**
     * @return Collection|NotificationTask[]
     */
    private function getTasks(): Collection
    {
        return tdf_query_notification_tasks()
            ->waiting()
            ->orderByOldest()
            ->get();
    }
}