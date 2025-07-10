<?php

namespace Tangibledesign\Framework\Actions\Search;

use Tangibledesign\Framework\Models\Term\CustomTerm;

class FetchTermsByParentTaxonomyTermsAction
{
    public function execute(string $taxonomyKey, array $parentTermIds): array
    {
        return tdf_collect($this->getTermsByParents($taxonomyKey, $parentTermIds))
            ->map(function ($term) {
                return tdf_term_factory()->create($term);
            })
            ->unique()
            ->filter(function ($term) use ($parentTermIds) {
                if (!$term instanceof CustomTerm) {
                    return false;
                }

                if (empty($parentTermIds)) {
                    return true;
                }

                $currentTermParentTermIds = $term->getParentTermIds();
                foreach ($parentTermIds as $parentTermId) {
                    if (in_array((int)$parentTermId, $currentTermParentTermIds, true)) {
                        return true;
                    }
                }

                return false;
            })
            ->values();
    }

    private function getTermsByParents(string $taxonomyKey, array $parentTermIds): array
    {
        if (empty($parentTermIds)) {
            return $this->getTerms($taxonomyKey, 0);
        }

        $terms = [];

        foreach ($parentTermIds as $parentTermId) {
            $terms[] = $this->getTerms($taxonomyKey, (int)$parentTermId);
        }

        return array_merge([], ...$terms);
    }

    private function getTerms(string $taxonomyKey, int $parentTermId): array
    {
        $args = [
            'taxonomy' => $taxonomyKey,
            'hide_empty' => false,
        ];

        if (!empty($parentTermId)) {
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