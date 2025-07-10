<?php

namespace Tangibledesign\Framework\Providers\ModelWidget;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Term\Term;

class ModelsByTabServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/modelWidget/queryByTab', [$this, 'response']);
        add_action('admin_post_nopriv_'.tdf_prefix().'/modelWidget/queryByTab', [$this, 'response']);
    }

    public function response(): void
    {
        $template = $_POST['template'] ?? '';
        if (empty($template)) {
            return;
        }

        global ${tdf_short_prefix().'Models'};
        ${tdf_short_prefix().'Models'} = $this->getModels();

        get_template_part('templates/partials/'.$template);
    }

    /**
     * @return Collection
     */
    public function getModels(): Collection
    {
        if (!isset($_POST['limit'], $_POST['tab'])) {
            return tdf_collect();
        }

        $limit = (int) $_POST['limit'];
        $tab = htmlspecialchars($_POST['tab']);
        $includeExcluded = !empty($_POST['includeExcluded']);
        $orderBy = $_POST['orderBy'] ?? 'newest';
        $featuredOnly = !empty($_POST['featuredOnly']);

        if ($tab === 'most_popular') {
            return $this->getMostPopular($limit, $includeExcluded, $orderBy);
        }

        if ($tab === 'recently_viewed') {
            return $this->getRecentlyViewed($limit, $includeExcluded, $orderBy);
        }

        if ($tab === 'all') {
            return $this->getAll($limit, $includeExcluded, $orderBy, $featuredOnly);
        }

        return $this->getByTerm($tab, $limit, $includeExcluded, $orderBy, $featuredOnly);
    }

    /**
     * @param  int  $limit
     * @param  bool  $includeExcluded
     * @param  string  $orderBy
     * @return Collection
     */
    private function getMostPopular(int $limit, bool $includeExcluded, string $orderBy = 'newest'): Collection
    {
        $query = tdf_query_models()
            ->mostPopular()
            ->orderBy($orderBy)
            ->take($limit);

        if (!$includeExcluded) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        return $query->get();
    }

    /**
     * @param  int  $limit
     * @param  bool  $includeExcluded
     * @param  string  $orderBy
     * @return Collection
     */
    private function getRecentlyViewed(int $limit, bool $includeExcluded, string $orderBy = 'newest'): Collection
    {
        $query = tdf_query_models()
            ->recentlyViewed()
            ->orderBy($orderBy)
            ->take($limit);

        if (!$includeExcluded) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        return $query->get();
    }

    /**
     * @param  int  $limit
     * @param  bool  $includeExcluded
     * @param  string  $orderBy
     * @param  bool  $featuredOnly
     * @return Collection
     */
    private function getAll(
        int $limit,
        bool $includeExcluded,
        string $orderBy = 'newest',
        bool $featuredOnly = false
    ): Collection {
        $query = tdf_query_models()
            ->orderBy($orderBy)
            ->take($limit);

        if (!$includeExcluded) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        if ($featuredOnly) {
            $query->featured();
        }

        return $query->get();
    }

    /**
     * @param  int  $termId
     * @param  int  $limit
     * @param  bool  $includeExcluded
     * @param  string  $orderBy
     * @param  bool  $featuredOnly
     * @return Collection
     * @noinspection PhpMissingParamTypeInspection
     */
    private function getByTerm(
        $termId,
        int $limit,
        bool $includeExcluded,
        string $orderBy = 'newest',
        bool $featuredOnly = false
    ): Collection {
        $term = tdf_term_factory()->create((int) $termId);
        if (!$term instanceof Term) {
            return tdf_collect();
        }

        $query = tdf_query_models()
            ->setTaxQuery([
                [
                    'taxonomy' => $term->getTaxonomyKey(),
                    'field' => 'term_id',
                    'operator' => 'IN',
                    'terms' => [$termId]
                ]
            ])
            ->orderBy($orderBy)
            ->take($limit);

        if (!$includeExcluded) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        if ($featuredOnly) {
            $query->featured();
        }

        return $query->get();
    }

}