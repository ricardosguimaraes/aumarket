<?php

namespace Tangibledesign\Framework\Providers\Notifications;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Notification\ModelExpireNotification;
use Tangibledesign\Framework\Models\Notification\Trigger;

class ModelExpireNotificationsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action(tdf_prefix() . '/notifications/modelExpire/check', [$this, 'handle']);

        add_action('admin_init', function () {
            if (!wp_next_scheduled(tdf_prefix() . '/notifications/modelExpire/check')) {
                wp_schedule_event(time(), 'every_minute', tdf_prefix() . '/notifications/modelExpire/check');
            }
        });
    }

    public function handle(): void
    {
        foreach ($this->getNotifications() as $notification) {
            $this->checkModels($notification);
        }
    }

    /**
     * @return Collection|ModelExpireNotification[]
     */
    private function getNotifications(): Collection
    {
        return tdf_query_notifications()
            ->trigger(Trigger::MODEL_EXPIRE)
            ->get()
            ->filter(static function ($notification) {
                return $notification instanceof ModelExpireNotification;
            });
    }

    private function checkModels(ModelExpireNotification $notification): void
    {
        foreach ($this->getModels($notification->getHours()) as $model) {
            $this->checkModel($model, $notification);
        }
    }

    private function checkModel(Model $model, ModelExpireNotification $notification): void
    {
        if ($model->hasExpireNotification($notification->getId())) {
            return;
        }

        $notification->createTasks([
            'user' => $model->getUserId(),
            'model' => $model->getId(),
        ]);

        $model->addExpireNotification($notification->getId());
    }

    /**
     * @param int $hours
     * @return Collection|Model[]
     */
    private function getModels(int $hours): Collection
    {
        return tdf_query_models()
            ->expiresLessThan($hours)
            ->get();
    }
}