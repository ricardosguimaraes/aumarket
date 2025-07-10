<?php

namespace TangibleDesign\Framework\Providers\Seo;

use Tangibledesign\Framework\Actions\Search\SearchTitleAndDescriptionAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use WP_Term;

abstract class BaseSeoServiceProvider extends ServiceProvider
{
    protected ?WP_Term $currentTerm = null;

    protected function getFullTitle(): string
    {
        return (new SearchTitleAndDescriptionAction())->getTitle();
    }

    protected function getCurrentTitleTerm(): ?CustomTerm
    {
        $term = $this->fetchTitleTerm(tdf_settings()->getSearchTitleFields2());
        if ($term) {
            return $term;
        }

        return $this->fetchTitleTerm(tdf_settings()->getSearchTitleFields());
    }

    private function fetchTitleTerm(Collection $fields): ?CustomTerm
    {
        $termSlugs = [];
        $taxonomyKey = '';

        foreach ($fields as $field) {
            /* @var TaxonomyField $fieldField */
            $slug = $field->getSlug();
            $value = get_query_var($field->getKey());

            if (empty($value)) {
                if (empty($_GET[$slug])) {
                    continue;
                }

                $value = $_GET[$slug];
            }

            $taxonomyKey = $field->getKey();
            /** @noinspection SlowArrayOperationsInLoopInspection */
            $termSlugs = array_merge($termSlugs, explode(',', $value));
        }

        $term = $this->fetchWpTerm($termSlugs, $taxonomyKey);
        if (!$term) {
            return null;
        }

        return new CustomTerm($term);
    }

    private function fetchWpTerm(array $termSlugs, string $taxonomyKey): ?WP_Term
    {
        $termSlugs = tdf_collect($termSlugs)->filter(static function ($termSlug) {
            return !empty($termSlug);
        })->values();

        if (empty($termSlugs)) {
            return null;
        }

        $termSlug = $termSlugs[count($termSlugs) - 1];
        $term = get_term_by('slug', $termSlug, $taxonomyKey);
        if (!$term instanceof WP_Term) {
            return null;
        }

        return $term;
    }

    protected function getCurrentBreadcrumbTerm(): ?WP_Term
    {
        if ($this->currentTerm) {
            return $this->currentTerm;
        }

        $termSlugs = [];
        $taxonomyKey = '';

        foreach (tdf_app('breadcrumbs_taxonomies') as $taxonomy) {
            /* @var TaxonomyField $taxonomy */
            $slug = $taxonomy->getSlug();
            $value = get_query_var($taxonomy->getKey());

            if (empty($value)) {
                if (empty($_GET[$slug])) {
                    break;
                }

                $value = $_GET[$slug];
            }

            $taxonomyKey = $taxonomy->getKey();
            /** @noinspection SlowArrayOperationsInLoopInspection */
            $termSlugs = array_merge($termSlugs, explode(',', $value));
        }

        $this->currentTerm = $this->fetchWpTerm($termSlugs, $taxonomyKey);

        return $this->currentTerm;
    }
}