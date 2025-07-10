<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Notification\Trigger;

class CheckExpireModelsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_nopriv_' . tdf_prefix() . '/models/checkExpired', [$this, 'checkAdvanced']);
        add_action('admin_post_' . tdf_prefix() . '/models/checkExpired', [$this, 'checkAdvanced']);

        add_action(tdf_prefix() . '/models/checkExpired', [$this, 'check']);

        add_action('admin_init', [$this, 'scheduleCheck']);
    }

    public function scheduleCheck(): void
    {
        if (!wp_next_scheduled(tdf_prefix() . '/models/checkExpired')) {
            wp_schedule_event(time(), 'every_minute', tdf_prefix() . '/models/checkExpired');
        }
    }

    public function checkAdvanced(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $this->check();

        wp_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_advanced&tab=tools'));
        exit;
    }

    public function check(): void
    {
        foreach (tdf_query_models()->expired()->get() as $model) {
            /* @var Model $model */
            if (!$model->isPublished()) {
                continue;
            }

            $model->setDraft();

            $model->clearExpireDate();

            $model->removeAssignedPackage();

            $model->clearExpireNotifications();

            do_action(tdf_prefix() . '/notifications/trigger', Trigger::MODEL_EXPIRED, [
                'user' => $model->getUserId(),
                'model' => $model->getId(),
            ]);
        }

        foreach (tdf_query_models()->featuredExpired()->get() as $model) {
            /* @var Model $model */
            if (!$model->isFeatured()) {
                continue;
            }
            $model->setFeatured(0);

            if ($model->isPublished()) {
                do_action(tdf_prefix() . '/notifications/trigger', Trigger::MODEL_FEATURED_EXPIRED, [
                    'user' => $model->getUserId(),
                    'model' => $model->getId(),
                ]);
            }

            $model->clearFeaturedExpireDate();
        }
    }
}