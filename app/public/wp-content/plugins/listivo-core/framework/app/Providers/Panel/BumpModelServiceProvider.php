<?php

namespace Tangibledesign\Framework\Providers\Panel;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Post\PostStatus;
use WP_Query;

class BumpModelServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_init', [$this, 'scheduleCheck']);

        add_action(tdf_prefix().'/models/checkBumps', [$this, 'check']);
    }

    public function scheduleCheck(): void
    {
        if (!wp_next_scheduled(tdf_prefix().'/models/checkBumps')) {
            wp_schedule_event(time(), 'every_minute', tdf_prefix().'/models/checkBumps');
        }
    }

    public function check(): void
    {
        if (!tdf_settings()->bumpsEnabled()) {
            return;
        }

        foreach ($this->getModels() as $model) {
            if ($model->shouldBeBumped()) {
                $this->bump($model);
            }
        }
    }

    /**
     * @param  Model  $model
     * @return void
     */
    private function bump(Model $model): void
    {
        $model->bump();

        $model->setNextBumpDate($model->shiftBumpDates());

        do_action(tdf_prefix().'/notifications/trigger', Trigger::MODEL_BUMPED, [
            'user' => $model->getUserId(),
            'model' => $model->getId(),
        ]);
    }

    /**
     * @return Collection|Model[]
     */
    private function getModels(): Collection
    {
        $query = new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'post_status' => PostStatus::PUBLISH,
            'meta_query' => [
                [
                    'key' => 'next_bump_date',
                    'value' => date("Y-m-d H:i:s"),
                    'compare' => '<=',
                ]
            ]
        ]);

        return tdf_collect($query->posts)->map(static function ($post) {
            return tdf_post_factory()->create($post);
        });
    }

}