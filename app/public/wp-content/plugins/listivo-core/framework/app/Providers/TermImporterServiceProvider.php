<?php

namespace Tangibledesign\Framework\Providers;

use Cocur\Slugify\Slugify;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use WP_Term;

class TermImporterServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/termImporter/import', [$this, 'import']);
    }

    public function import(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (empty($_POST['parent_taxonomy'])) {
            wp_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_advanced&tab=terms_importer'));
            exit;
        }

        $parentTaxonomyKey = $_POST['parent_taxonomy'];
        $parentTaxonomy = tdf_taxonomy_fields()->find(static function ($taxonomy) use ($parentTaxonomyKey) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getKey() === $parentTaxonomyKey;
        });

        if (!$parentTaxonomy instanceof TaxonomyField) {
            wp_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_advanced&tab=terms_importer'));
            exit;
        }

        foreach ($this->getParentTerms() as $index => $parentTerm) {
            $parentTerm = trim($parentTerm);
            if (empty($parentTerm)) {
                continue;
            }

            $parentTermId = $this->addTerm($parentTerm, $parentTaxonomy);

            if (!empty($_POST['child_taxonomy']) && is_array($_POST['child_taxonomy'])) {
                foreach ($_POST['child_taxonomy'] as $key => $childTaxonomyKey) {
                    $childTaxonomy = tdf_taxonomy_fields()->find(static function ($taxonomy) use ($childTaxonomyKey) {
                        /* @var TaxonomyField $taxonomy */
                        return $taxonomy->getKey() === $childTaxonomyKey;
                    });
                    if ($childTaxonomy) {
                        $childTerms = explode("\n", str_replace("\r", "", $_POST['child_terms'][$key]));
                    } else {
                        $childTerms = [];
                    }

                    if (empty($childTerms[$index])) {
                        continue;
                    }

                    $this->addChildTerm(trim($childTerms[$index]), $childTaxonomy, $parentTermId);
                }
            }
        }

        wp_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_advanced&tab=terms_importer'));
        exit;
    }

    /**
     * @return array
     */
    private function getParentTerms(): array
    {
        $terms = explode("\n", str_replace("\r", "", $_POST['parent_terms']));

        if (!is_array($terms)) {
            return [];
        }

        return $terms;
    }

    /**
     * @param string $term
     * @param TaxonomyField $taxonomy
     * @return int
     */
    private function addTerm(string $term, TaxonomyField $taxonomy): int
    {
        $wpTerm = get_term_by('name', $term, $taxonomy->getKey());

        if ($wpTerm instanceof WP_Term) {
            return $wpTerm->term_id;
        }

        $termData = wp_insert_term($term, $taxonomy->getKey());
        if (is_wp_error($termData)) {
            return 0;
        }

        return $termData['term_id'];
    }

    /**
     * @param string $term
     * @param TaxonomyField $taxonomy
     * @param int $parentTermId
     * @param int $counter
     */
    private function addChildTerm(string $term, TaxonomyField $taxonomy, int $parentTermId, int $counter = 1): void
    {
        $name = $term;

        if ($counter > 1) {
            $name .= ' ' . $counter;
        }

        $counter++;

        $termData = wp_insert_term($term, $taxonomy->getKey(), [
            'slug' => Slugify::create()->slugify($name)
        ]);

        if (is_wp_error($termData)) {
            $this->addChildTerm($term, $taxonomy, $parentTermId, $counter);
            return;
        }

        update_term_meta($termData['term_id'], CustomTerm::PARENT_TERMS, [$parentTermId]);
    }

}