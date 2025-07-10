<?php

namespace Tangibledesign\Framework\Search\Helpers;

use Tangibledesign\Framework\Models\Post\PostStatus;
use WP_Query;

trait QueryModels
{
    protected function queryModels(string $postType, array $queryPartial): array
    {
        $cacheEnabled = tdf_settings()->isCacheEnabled();
        if ($cacheEnabled) {
            $cacheKey = tdf_prefix() . '_cache_' . md5(serialize($queryPartial));
            $cachedPosts = get_transient($cacheKey);

            if ($cachedPosts !== false) {
                return $cachedPosts;
            }
        }

        $posts = (new WP_Query([
                'post_type' => $postType,
                'posts_per_page' => -1,
                'post_status' => PostStatus::PUBLISH,
                'fields' => 'ids',
                'no_found_rows' => true,
                'update_post_term_cache' => false,
                'update_post_meta_cache' => false,
            ] + $queryPartial))->posts;

        if ($cacheEnabled) {
            set_transient($cacheKey, $posts, tdf_settings()->getCacheDuration());
        }

        return $posts;
    }

    protected function metaQueryModels(string $postType, array $queryPartial): array
    {
        return $this->queryModels($postType, [
            'meta_query' => [$queryPartial],
        ]);
    }

    protected function taxQueryModels(string $postType, array $queryPartial): array
    {
        return $this->queryModels($postType, [
            'tax_query' => [$queryPartial],
        ]);
    }
}