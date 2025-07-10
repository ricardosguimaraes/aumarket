<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class CronServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function afterInitiation(): void
    {
        add_filter('cron_schedules', static function ($schedules) {
            $schedules['every_five_minutes'] = array(
                'interval' => 300,
                'display' => tdf_admin_string('every_five_minutes'),
            );

            $schedules['every_minute'] = array(
                'interval' => 60,
                'display' => tdf_admin_string('every_minute'),
            );

            return $schedules;
        });
    }

}