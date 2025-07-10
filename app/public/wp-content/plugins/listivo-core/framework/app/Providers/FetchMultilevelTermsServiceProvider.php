<?php

namespace Tangibledesign\Framework\Providers;

use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use WP_Term;

class FetchMultilevelTermsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/terms/multilevel/fetch', [$this, 'fetch']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/terms/multilevel/fetch', [$this, 'fetch']);
    }

    public function fetch(): void
    {
        $taxonomyKey = $_POST['taxonomyKey'] ?? '';
        $selectedTermIds = $_POST['selectedTermIds'] ?? [];
        $parentTermIds = $_POST['parentTermIds'] ?? [];

        if (empty($taxonomyKey)) {
            echo '[]';
            return;
        }

        if (empty($parentTermIds)) {
            try {
                echo json_encode(['terms' => $this->sanitizeTerms($this->getTerms($taxonomyKey, $selectedTermIds))], JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                echo '[]';
            }
            return;
        }

        $terms = [];

        foreach ($parentTermIds as $parentTermId) {
            $parentTermId = (int)$parentTermId;
            if (empty($parentTermId)) {
                $parentTermId = null;
            }

            $terms[] = $this->getTerms($taxonomyKey, $selectedTermIds, $parentTermId);
        }

        $terms = array_merge([], ...$terms);

        try {
            echo json_encode(['terms' => $this->sanitizeTerms($terms)], JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            echo '[]';
        }
    }

    private function sanitizeTerms(array $terms): array
    {
        return tdf_collect($terms)
            ->map(function ($term) {
                return tdf_term_factory()->create($term);
            })
            ->unique()
            ->values();
    }

    private function getTerms(string $taxonomyKey, array $selectedTermIds, ?int $parentTermId = null): array
    {
        $terms = [];

        $terms[] = $this->fetchTerms($taxonomyKey, 0, $parentTermId);

        foreach ($selectedTermIds as $termId) {
            $term = get_term($termId, $taxonomyKey);
            if ($term instanceof WP_Term) {
                $terms[] = [$term];
            }

            $terms[] = $this->fetchTerms($taxonomyKey, $termId, $parentTermId);
        }

        $terms = array_merge([], ...$terms);

        $finalTerms = [$terms];

        foreach ($terms as $term) {
            if (!empty($selectedTermIds) && $term->parent === 0) {
                continue;
            }

            $finalTerms[] = $this->fetchTerms($taxonomyKey, $term->term_id, $parentTermId);
        }

        return array_merge([], ...$finalTerms);
    }

    private function fetchTerms(string $taxonomyKey, int $parent, ?int $parentTermId = null): array
    {
        $args = [
            'taxonomy' => $taxonomyKey,
            'hide_empty' => false,
            'parent' => $parent,
        ];

        if ($parentTermId !== null) {
            $args['meta_query'] = [
                [
                    'key' => CustomTerm::PARENT_TERMS,
                    'value' => $parentTermId,
                    'compare' => 'LIKE',
                ],
            ];
        }

        $terms = get_terms($args);
        if (!is_array($terms)) {
            return [];
        }

        return $terms;
    }
}