<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use WP_Query;

class FixBugsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/bugs/featured', [$this, 'featured']);

        add_action(tdf_prefix() . '/bugs/featured', [$this, 'fixFeatured']);
    }

    public function fixFeatured(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $query = new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query' => [
                [
                    'key' => 'featured',
                    'compare' => 'NOT EXISTS',
                ]
            ]
        ]);

        foreach ($query->posts as $postId) {
            update_post_meta($postId, 'featured', '0');
        }
    }

    public function featured(): void
    {
        $this->fixFeatured();

        wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_advanced&tab=tools'));
        exit;
    }
}