<?php

namespace Tangibledesign\Listivo\Providers;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Search\SearchModels;
use WP_REST_Request;

class SearchListingsServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route('listivo/v1', '/listings/', [
                'methods' => ['GET', 'POST'],
                'callback' => [$this, 'results'],
                'permission_callback' => '__return_true',
            ]);
        });

        add_filter('listivo/search/urlPartials', static function (Collection $urlPartials, string $template) {
            if ($template === 'templates/partials/search_results_card_regular' || $template === 'templates/partials/search_results_card_small') {
                $urlPartials[] = tdf_slug('view') . '=' . tdf_slug('card');
            } elseif ($template === 'templates/partials/search_results_simple_card') {
                $urlPartials[] = tdf_slug('view') . '=' . tdf_slug('simple_card');
            } elseif ($template === 'templates/partials/search_results_row' || $template === 'templates/partials/search_results_row_regular' || $template === 'templates/partials/search_results_row_regular_v2') {
                $urlPartials[] = tdf_slug('view') . '=' . tdf_slug('row');
            }

            return $urlPartials;
        }, 10, 2);
    }

    public function results(WP_REST_Request $request): array
    {
        $searchListings = new SearchModels($request->get_params(), $this->getLocationField());

        return $searchListings->getResults();
    }

    private function getLocationField(): ?LocationField
    {
        $locationFieldId = (int)($_POST['locationFieldId'] ?? 0);
        if ($locationFieldId === 0) {
            return null;
        }

        $locationField = tdf_location_fields()->find(static function ($locationField) use ($locationFieldId) {
            /* @var LocationField $locationField */
            return $locationField->getId() === $locationFieldId;
        });

        return $locationField instanceof LocationField ? $locationField : null;
    }
}