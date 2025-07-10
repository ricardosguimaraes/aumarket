<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use WP_Term;

/**
 * Class TermUrlServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class TermUrlServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_filter(tdf_prefix() . '/term/url', [$this, 'url'], 10, 2);

        add_filter('term_link', [$this, 'wpUrl'], 10, 3);
    }

    /**
     * @param string $url
     * @param WP_Term $term
     * @param string $taxonomyKey
     * @return string
     */
    public function wpUrl(string $url, WP_Term $term, string $taxonomyKey): string
    {
        $check = tdf_taxonomy_fields()->find(static function (TaxonomyField $taxonomy) use ($taxonomyKey) {
            return $taxonomy->getKey() === $taxonomyKey;
        });

        if (!$check) {
            return $url;
        }

        return apply_filters(tdf_prefix() . '/term/url', $url, tdf_term_factory()->create($term));
    }

    /**
     * @param string $url
     * @param CustomTerm|false $term
     * @param bool $baseUrl
     * @return string
     */
    public function url(string $url, $term = false, bool $baseUrl = true): string
    {
        if (!$term) {
            return $url;
        }

        $taxonomy = $term->getTaxonomyField();
        if (!$taxonomy) {
            return $url;
        }

        $termUrl = $baseUrl ? get_post_type_archive_link(tdf_model_post_type()) : '';
        $parentTerms = $this->fetchParentTerms($term->getParentTerms());

        if ($taxonomy->isMultilevel()) {
            $parentTerms = $parentTerms->merge($term->getMultilevelParents());
        }

        if ($parentTerms->isNotEmpty()) {
            $termUrl .= '?';
        }

        $previousTaxonomyId = 0;

        foreach ($parentTerms as $index => $parentTerm) {
            /* @var CustomTerm $parentTerm */
            $taxonomyField = $parentTerm->getTaxonomyField();
            if (!$taxonomyField) {
                continue;
            }

            if ($previousTaxonomyId === $parentTerm->getTaxonomyField()->getId()) {
                $termUrl .= ',' . $parentTerm->getSlug();
                continue;
            }

            if ($index) {
                $termUrl .= '&';
            }

            $termUrl .= $parentTerm->getTaxonomyField()->getSlug() . '=' . $parentTerm->getSlug();
            $previousTaxonomyId = $parentTerm->getTaxonomyField()->getId();
        }

        if ($parentTerms->isEmpty()) {
            $termUrl .= '?';
        }

        if ($previousTaxonomyId === $taxonomy->getId()) {
            $termUrl .= ',' . $term->getSlug();
        } else {
            if ($parentTerms->isNotEmpty()) {
                $termUrl .= '&';
            }

            $termUrl .= $taxonomy->getSlug() . '=' . $term->getSlug();
        }

        return $termUrl;
    }

    /**
     * @param Collection|CustomTerm[] $terms
     * @return Collection
     */
    private function fetchParentTerms(Collection $terms): Collection
    {
        $output = tdf_collect();

        foreach ($terms as $term) {
            $output = $output->merge($this->fetchParentTerms($term->getParentTerms()));

            $taxonomyField = $term->getTaxonomyField();
            if ($taxonomyField && $taxonomyField->isMultilevel()) {
                $output = $output->merge($term->getMultilevelParents());
            }

            $output[] = $term;
        }

        return $output;
    }

}