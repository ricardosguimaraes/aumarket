<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;

class KeywordServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_filter('posts_where', static function ($where, $query) {
            global $wpdb;
            if ($keyword = $query->get('search_title')) {
                $where .= " AND " . $wpdb->posts . ".post_title LIKE '%" . esc_sql($wpdb->esc_like($keyword)) . "%'";
            }

            if ($keyword = $query->get('search_description')) {
                $where .= " AND " . $wpdb->posts . ".post_content LIKE '%" . esc_sql($wpdb->esc_like($keyword)) . "%'";
            }

            if ($keyword = $query->get('search_keyword')) {
                $where .= " AND (
                    " . $wpdb->posts . ".post_title LIKE '%" . esc_sql($wpdb->esc_like($keyword)) . "%'
                        OR " . $wpdb->posts . ".post_content LIKE '%" . esc_sql($wpdb->esc_like($keyword)) . "%'
                    ) ";
            }

            return $where;
        }, 10, 2);

        add_action('admin_post_' . tdf_prefix() . '/keyword', [$this, 'suggestions']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/keyword', [$this, 'suggestions']);
    }

    public function suggestions(): void
    {
        $keyword = mb_strtolower($_POST['keyword'] ?? '');
        $taxonomyKeys = $_POST['taxonomyKeys'] ?? [];
        $limit = (int)($_POST['keywordSuggestionLimit'] ?? 10);

        if (empty($keyword)) {
            $this->jsonResponse([
                'options' => [],
            ]);
            return;
        }

        if (tdf_settings()->isKeywordSearchTermsEnabled()) {
            $options = $this->getTermOptions($keyword, $taxonomyKeys, tdf_collect(), $limit);
        } else {
            $options = tdf_collect();
        }

        $this->jsonResponse([
            'options' => apply_filters(tdf_prefix() . '/keyword/options', $options, $keyword, $taxonomyKeys, $limit),
        ]);
    }

    /**
     * @param string $keyword
     * @param array $taxonomyKeys
     * @param Collection $options
     * @param int $limit
     * @return Collection
     */
    private function getTermOptions(string $keyword, array $taxonomyKeys, Collection $options, int $limit = 10): Collection
    {
        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            if (!in_array($taxonomyField->getKey(), $taxonomyKeys, true)) {
                continue;
            }

            $partialOptions = $this->findTerms($taxonomyField, $keyword);
            if ($partialOptions) {
                $options = $options->merge($partialOptions);
            }
        }

        return $options->take($limit);
    }

    /**
     * @param TaxonomyField $taxonomyField
     * @param string $keyword
     * @return Collection|false
     */
    private function findTerms(TaxonomyField $taxonomyField, string $keyword)
    {
        $terms = tdf_query_terms($taxonomyField->getKey())->setKeyword($keyword)->get();
        if ($terms->isEmpty()) {
            return false;
        }

        $options = tdf_collect();

        foreach ($terms as $term) {
            /* @var CustomTerm $term */
            $allParents = $term->getAllParentTerms();
            $values = $term->getParentTerms();

            $selectedFields = [];
            foreach ($allParents as $parent) {
                $field = $parent->getTaxonomyField();
                if ($field) {
                    $selectedFields[] = $field->getId();
                }
            }

            foreach (tdf_app('dependency_terms') as $dependencyTerm) {
                /* @var CustomTerm $dependencyTerm */
                $dependencies = $dependencyTerm->getFieldDependencies();
                foreach ($selectedFields as $fieldId) {
                    if (in_array($fieldId, $dependencies, true)) {
                        $values[] = $dependencyTerm;

                        foreach ($dependencyTerm->getAllParentTerms() as $dependencyParentTerm) {
                            $values[] = $dependencyParentTerm;
                        }
                    }
                }
            }

            $options[] = [
                'keyword' => '',
                'term' => mb_strtolower($term->getName(), 'UTF-8'),
                'termName' => $term->getName(),
                'taxonomy' => $taxonomyField->getKey(),
                'id' => $term->getId(),
                'value' => array_merge([$term->getId()], $term->getMultilevelParentIds()),
                'type' => 'taxonomy',
                'values' => $this->getParentOptions($values),
            ];
        }

        return $options;
    }

    /**
     * @param Collection|CustomTerm[] $terms
     * @return array
     */
    private function getParentOptions(Collection $terms): array
    {
        $options = [];

        $previousTaxonomyKey = '';

        foreach ($terms as $term) {
            $taxonomyKey = $term->getTaxonomyKey();
            if ($previousTaxonomyKey === $term->getTaxonomyKey()) {
                $options[$taxonomyKey]['values'][] = $term->getId();
                continue;
            }

            $options[$taxonomyKey] = [
                'key' => $taxonomyKey,
                'values' => [$term->getId()],
                'terms' => [
                    [
                        'id' => $term->getId(),
                        'name' => $term->getName(),
                    ]
                ]
            ];

            $previousTaxonomyKey = $taxonomyKey;
        }

        return $options;
    }
}