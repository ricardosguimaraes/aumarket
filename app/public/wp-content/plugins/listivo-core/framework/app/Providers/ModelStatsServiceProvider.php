<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class ModelStatsServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class ModelStatsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('wp_head', [$this, 'stats']);
    }

    public function stats(): void
    {
        if (!is_singular(tdf_model_post_type())) {
            return;
        }

        global $post;
        if (!$post) {
            return;
        }

        $this->increaseViews($post->ID);

        $this->updateRecentlyViewed($post->ID);
    }

    /**
     * @param int $modelId
     */
    private function updateRecentlyViewed(int $modelId): void
    {
        global $wpdb;

        $tableName = $wpdb->prefix . tdf_prefix() . '_recently_viewed';

        $wpdb->insert($tableName, [
            'model_id' => $modelId,
        ]);
    }

    /**
     * @param int $modelId
     */
    private function increaseViews(int $modelId): void
    {
        global $wpdb;
        $tableName = $wpdb->prefix . tdf_prefix() . '_views';
        $date = date("Y-m-d");

        $results = $wpdb->get_results("SELECT * FROM {$tableName} WHERE `date` = '{$date}' AND `model_id` = {$modelId}");
        if (empty($results)) {
            $wpdb->insert($tableName, [
                'model_id' => $modelId,
                'date' => $date,
                'count' => 1,
            ]);
        } else {
            $wpdb->update(
                $tableName,
                [
                    'count' => $results[0]->count + 1
                ],
                [
                    'id' => $results[0]->id
                ]
            );
        }
    }

}