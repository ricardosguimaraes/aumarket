<?php

namespace Tangibledesign\Framework\Providers\Notifications;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Notification\Notification;

class CreateNotificationTasksServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action(tdf_prefix().'/notifications/trigger', [$this, 'trigger'], 10, 2);
    }

    public function trigger(string $trigger, array $args = []): void
    {
        foreach ($this->getNotifications($trigger) as $notification) {
            $notification->createTasks($args);
        }
    }

    /**
     * @param  string  $trigger
     * @return Collection|Notification[]
     */
    private function getNotifications(string $trigger): Collection
    {
        return tdf_query_notifications()
            ->trigger($trigger)
            ->get();
    }
}