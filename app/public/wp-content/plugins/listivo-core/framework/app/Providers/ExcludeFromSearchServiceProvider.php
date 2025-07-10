<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use WP_Query;

class ExcludeFromSearchServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['models_excluded_from_search'] = static function () {
            $ids = [];

            foreach (tdf_app('terms_excluded_from_search') as $term) {
                /* @var CustomTerm $term */
                $query = new WP_Query([
                    'post_type' => tdf_model_post_type(),
                    'post_status' => PostStatus::PUBLISH,
                    'posts_per_page' => -1,
                    'fields' => 'ids',
                    'update_post_meta_cache' => true,
                    'update_post_term_cache' => true,
                    'tax_query' => [
                        [
                            'taxonomy' => $term->getTaxonomyKey(),
                            'terms' => [$term->getSlug()],
                            'field' => 'slug',
                        ]
                    ]
                ]);

                /** @noinspection SlowArrayOperationsInLoopInspection */
                $ids = array_merge($ids, $query->posts);
            }

            return apply_filters(tdf_prefix() . '/search/excluded', array_unique($ids));
        };

        $this->container['terms_excluded_from_search'] = static function () {
            return tdf_collect(tdf_settings()->getExcludedFromSearchTermIds())->map(static function ($termId) {
                return tdf_term_factory()->create($termId);
            })->filter(static function ($term) {
                return $term !== false && $term !== null;
            });
        };
    }
}