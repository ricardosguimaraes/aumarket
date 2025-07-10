<?php


namespace Tangibledesign\Listivo\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class FavoriteListServiceProvider
 * @package Tangibledesign\Listivo\Providers
 */
class FavoriteListServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_listivo/panel/favorites', [$this, 'list']);
    }

    public function list(): void
    {
        $user = tdf_current_user();
        $favoriteIds = $user->getFavoriteIds();
        if (empty($favoriteIds)) {
            $this->jsonResponse([
                'template' => '',
                'count' => 0,
            ]);
            return;
        }

        $query = tdf_query_models()->in($favoriteIds);
        $sortBy = $this->getSortBy();

        if ($sortBy === tdf_slug('oldest')) {
            $query->orderByOldest();
        } else {
            $query->orderByNewest();
        }

        global $lstCurrentListings;
        $lstCurrentListings = $query->get();

        if ($lstCurrentListings->isEmpty()) {
            $this->jsonResponse([
                'template' => '',
                'count' => 0,
            ]);
            return;
        }

        ob_start();

        get_template_part($this->getTemplate());

        $this->jsonResponse([
            'template' => ob_get_clean(),
            'count' => $query->getResultsNumber(),
        ]);
    }

    /**
     * @return string
     */
    private function getTemplate(): string
    {
        $template = $_POST['template'] ?? 'templates/partials/search_results_row';

        if ($template !== 'templates/partials/search_results_row' && $template !== 'templates/partials/search_results_card_small') {
            return 'templates/partials/search_results_row';
        }

        return $template;
    }

    /**
     * @return string
     */
    private function getSortBy(): string
    {
        $sortBy = $_POST['sortBy'] ?? tdf_slug('newest');

        if ($sortBy !== tdf_slug('newest') && $sortBy !== tdf_slug('oldest')) {
            return tdf_slug('newest');
        }

        return $sortBy;

    }

}