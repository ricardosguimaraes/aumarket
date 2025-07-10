<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class QueryTermsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_tdf/terms/query', [$this, 'query']);
    }

    public function query(): void
    {
        if (!current_user_can('manage_options')) {
            wp_send_json([]);
        }

        $query = $_POST['query'] ?? '';
        if (empty($query)) {
            wp_send_json([]);
        }

        $terms = [];

        foreach (tdf_taxonomy_keys() as $taxonomyKey) {
            $tempTerms = get_terms([
                'taxonomy' => $taxonomyKey,
                'hide_empty' => false,
                'search' => $query,
            ]);

            if (is_array($tempTerms)) {
                $terms[] = $tempTerms;
            }
        }

        $response = tdf_collect(array_merge(...$terms))
            ->map(static function ($term) {
                return tdf_term_factory()->create($term);
            })
            ->filter(static function ($term) {
                return $term !== null;
            })
            ->unique()
            ->map(static function ($term) {
                return [
                    'value' => $term->getId(),
                    'label' => $term->getName(),
                ];
            })
            ->values();

        wp_send_json($response);
    }

}