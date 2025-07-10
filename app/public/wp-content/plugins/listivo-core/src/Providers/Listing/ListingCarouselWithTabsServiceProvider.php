<?php


namespace Tangibledesign\Listivo\Providers\Listing;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Term\Term;

class ListingCarouselWithTabsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('wp_ajax_listivo/listingCarouselWithTabsWidget/listings', [$this, 'listings']);

        add_action('wp_ajax_nopriv_listivo/listingCarouselWithTabsWidget/listings', [$this, 'listings']);

        add_filter('listivo/listingCarouselWithTabsWidget/listings', function ($type, $limit, $includeExcluded) {
            return $this->getListings($type, $limit, $includeExcluded);
        }, 10, 3);
    }

    public function listings(): void
    {
        if (!isset($_POST['limit'], $_POST['tab'])) {
            exit;
        }

        $limit = (int)$_POST['limit'];
        $tab = htmlspecialchars($_POST['tab']);
        $includeExcluded = !empty($_POST['includeExcluded']);
        $cardType = $_POST['cardType'] ?? 'regular';
        $listings = $this->getListings($tab, $limit, $includeExcluded);
        ?>
        <div class="listivo-swiper-container">
            <div class="listivo-swiper-wrapper">
                <?php
                global $lstCurrentListing;
                foreach ($listings as $lstCurrentListing) : ?>
                    <div class="listivo-swiper-slide">
                        <?php get_template_part('templates/partials/card/listing_card_v3'); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        exit;
    }

    /**
     * @param string $tab
     * @param int $limit
     * @param bool $includeExcluded
     * @return Collection
     */
    private function getListings(string $tab, int $limit, bool $includeExcluded): Collection
    {
        if ($tab === 'most_popular') {
            return $this->getMostPopular($limit, $includeExcluded);
        }

        if ($tab === 'recently_viewed') {
            return $this->getRecentlyViewed($limit, $includeExcluded);
        }

        if ($tab === 'all') {
            return $this->getAll($limit, $includeExcluded);
        }

        return $this->getByTerm($tab, $limit, $includeExcluded);
    }

    /**
     * @param int $limit
     * @param bool $includeExcluded
     * @return Collection
     */
    private function getMostPopular(int $limit, bool $includeExcluded): Collection
    {
        $query = tdf_query_models()
            ->mostPopular()
            ->take($limit);

        if (!$includeExcluded) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        return $query->get();
    }

    /**
     * @param int $limit
     * @param bool $includeExcluded
     * @return Collection
     */
    private function getRecentlyViewed(int $limit, bool $includeExcluded): Collection
    {
        $query = tdf_query_models()
            ->recentlyViewed()
            ->take($limit);

        if (!$includeExcluded) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        return $query->get();
    }

    /**
     * @param int $limit
     * @param bool $includeExcluded
     * @return Collection
     */
    private function getAll(int $limit, bool $includeExcluded): Collection
    {
        $query = tdf_query_models()
            ->take($limit);

        if (!$includeExcluded) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        return $query->get();
    }

    /**
     * @param int $termId
     * @param int $limit
     * @param bool $includeExcluded
     * @return Collection
     * @noinspection PhpMissingParamTypeInspection
     */
    private function getByTerm($termId, int $limit, bool $includeExcluded): Collection
    {
        $term = tdf_term_factory()->create((int)$termId);
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
            ->take($limit);

        if (!$includeExcluded) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        return $query->get();
    }

}