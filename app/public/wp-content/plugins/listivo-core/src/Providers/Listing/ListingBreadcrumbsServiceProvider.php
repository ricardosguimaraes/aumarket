<?php


namespace Tangibledesign\Listivo\Providers\Listing;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;


class ListingBreadcrumbsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_filter('listivo/breadcrumbs/listing/url', [$this, 'url'], 10, 2);

        add_filter('listivo/breadcrumbs/listings', [$this, 'listings']);
    }

    /**
     * @param array $args
     * @return array[]
     */
    public function listings(array $args): array
    {
        $breadcrumbs = [
            [
                'key' => 'home',
                'name' => tdf_string('home'),
                'url' => site_url(),
            ]
        ];

        $baseUrl = get_post_type_archive_link(tdf_model_post_type());
        $currentTerms = tdf_collect();

        $breadcrumbs[] = [
            'key' => 'results',
            'name' => tdf_string('search_results'),
            'url' => $baseUrl,
        ];

        foreach (tdf_app('breadcrumbs_taxonomies') as $taxonomy) {
            /* @var TaxonomyField $taxonomy */
            if (!isset($args[$taxonomy->getSlug()])) {
                continue;
            }

            $termSlugs = explode(',', $args[$taxonomy->getSlug()]);
            if (empty($termSlugs)) {
                continue;
            }

            $terms = $this->getTerms($termSlugs, $taxonomy);
            if ($terms->isEmpty()) {
                continue;
            }

            if ($taxonomy->isMultilevel()) {
                $values = [];
                foreach ($terms as $term) {
                    /* @var CustomTerm $term */
                    $values[$term->getMultilevelParentId()][] = [
                        'id' => $term->getId(),
                        'term' => $term,
                    ];
                }

                if (isset($values[0])) {
                    $terms = $taxonomy->getMultilevelValues($taxonomy->createMultilevelTermTree($values, $values[0]));
                    foreach ($terms as $term) {
                        $currentTerms[] = $term;

                        $breadcrumbs[] = [
                            'key' => $term->getKey(),
                            'name' => $term->getName(),
                            'url' => $this->url($baseUrl, $currentTerms),
                        ];
                    }
                }
            } else {
                foreach ($terms as $term) {
                    $currentTerms[] = $term;

                    $breadcrumbs[] = [
                        'key' => $term->getKey(),
                        'name' => $term->getName(),
                        'url' => $this->url($baseUrl, $currentTerms),
                    ];

                    break;
                }
            }
        }

        return $breadcrumbs;
    }

    /**
     * @param array $slugs
     * @param TaxonomyField $taxonomy
     * @return Collection
     */
    private function getTerms(array $slugs, TaxonomyField $taxonomy): Collection
    {
        return tdf_collect($slugs)->map(static function ($slug) use ($taxonomy) {
            return tdf_term_factory()->createBySlug($slug, $taxonomy->getKey());
        })->filter(static function ($term) {
            return $term !== false && $term !== null;
        });
    }

    /**
     * @param string $baseUrl
     * @param Collection|CustomTerm[] $terms
     * @return string
     */
    public function url(string $baseUrl, Collection $terms): string
    {
        if ($terms->isEmpty()) {
            return $baseUrl;
        }

        $currentUrl = $baseUrl . '?';
        $previousTaxonomyId = 0;

        foreach ($terms as $index => $term) {
            $taxonomyField = $term->getTaxonomyField();
            if (!$taxonomyField) {
                continue;
            }

            if ($previousTaxonomyId === $taxonomyField->getId()) {
                $currentUrl .= ',' . $term->getSlug();
                continue;
            }

            $previousTaxonomyId = $taxonomyField->getId();

            if ($index) {
                $currentUrl .= '&';
            }

            $currentUrl .= $term->getTaxonomyField()->getSlug() . '=' . $term->getSlug();
        }

        return apply_filters(tdf_prefix() . '/term/url', $currentUrl);
    }

}