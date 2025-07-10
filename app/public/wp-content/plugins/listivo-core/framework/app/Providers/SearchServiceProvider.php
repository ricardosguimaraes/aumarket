<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Search\HasQueryModifier;
use Tangibledesign\Framework\Search\QueryModifier\KeywordQueryModifier;
use Tangibledesign\Framework\Search\QueryModifier\UsersQueryModifier;
use Tangibledesign\Framework\Search\SearchParamModifier\LimitSearchParamModifier;
use Tangibledesign\Framework\Search\SearchParamModifier\OffsetSearchParamModifier;
use Tangibledesign\Framework\Search\SearchParamModifier\SortSearchParamModifier;
use Tangibledesign\Framework\Search\SearchResultsModifier;
use Tangibledesign\Framework\Search\SearchUrlModifier;
use Tangibledesign\Framework\Search\Sortable;
use Tangibledesign\Framework\Core\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['sort_by_options_with_random'] = static function () {
            $options = tdf_app('sort_by_options');
            $options['random'] = tdf_string('random');

            return $options;
        };

        $this->container['sort_by_options'] = static function () {
            $options = [
                'newest' => tdf_string('date_listed_newest'),
                'oldest' => tdf_string('date_listed_oldest'),
                'most_relevant' => tdf_string('most_relevant'),
                'name_asc' => tdf_string('name_asc'),
            ];

            foreach (tdf_app('sortable_fields') as $field) {
                /* @var Sortable $field */
                $key = $field->getKey() . '-high_to_low';
                $options[$key] = $field->getName() . ': ' . tdf_string('high_to_low');

                $key = $field->getKey() . '-low_to_high';
                $options[$key] = $field->getName() . ': ' . tdf_string('low_to_high');
            }

            return $options;
        };

        $this->container['sort_by_default_options'] = static function () {
            $options = [
                [
                    'name' => tdf_string('most_relevant'),
                    'type' => 'most_relevant'
                ],
                [
                    'name' => tdf_string('date_listed_newest'),
                    'type' => 'newest',
                ],
            ];

            foreach (tdf_app('sortable_fields') as $field) {
                /* @var Sortable $field */
                $options[] = [
                    'name' => $field->getName() . ': ' . tdf_string('high_to_low'),
                    'type' => $field->getKey() . '-high_to_low'
                ];

                $options[] = [
                    'name' => $field->getName() . ': ' . tdf_string('low_to_high'),
                    'type' => $field->getKey() . '-low_to_high'
                ];
            }

            return $options;
        };

        $this->container['search_query_modifiers'] = static function () {
            $queryModifiers = tdf_ordered_fields()->filter(static function ($field) {
                return $field instanceof HasQueryModifier;
            })->map(static function (HasQueryModifier $hasQueryModifier) {
                return $hasQueryModifier->getQueryModifier();
            });

            $queryModifiers[] = new KeywordQueryModifier();
            $queryModifiers[] = new UsersQueryModifier();

            return $queryModifiers;
        };

        $this->container['search_params_modifiers'] = static function () {
            return [
                new OffsetSearchParamModifier(),
                new LimitSearchParamModifier(),
                new SortSearchParamModifier(),
            ];
        };

        $this->container['search_results_modifiers'] = static function () {
            /** @noinspection NullPointerExceptionInspection */
            return tdf_app('search_query_modifiers')->filter(static function ($searchQueryModifier) {
                return $searchQueryModifier instanceof SearchResultsModifier;
            });
        };

        $this->container['search_url_modifiers'] = static function () {
            /** @noinspection NullPointerExceptionInspection */
            $searchUrlModifiers = tdf_app('search_query_modifiers')->filter(static function ($searchQueryModifier) {
                return $searchQueryModifier instanceof SearchUrlModifier;
            });

            foreach (tdf_app('search_params_modifiers') as $searchParamModifier) {
                if ($searchParamModifier instanceof SearchUrlModifier) {
                    $searchUrlModifiers[] = $searchParamModifier;
                }
            }

            return apply_filters(tdf_prefix() . '/search/urlModifiers', $searchUrlModifiers);
        };

        $this->container['search_title_fields'] = static function () {
            return tdf_settings()->getSearchTitleFields();
        };

        $this->container['search_title_fields_2'] = static function () {
            return tdf_settings()->getSearchTitleFields2();
        };

        $this->container['sortable_fields'] = static function () {
            return tdf_ordered_fields()->filter(static function ($field) {
                return $field instanceof Sortable;
            });
        };
    }

}