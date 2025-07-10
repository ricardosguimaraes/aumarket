<?php


namespace Tangibledesign\Framework\Models\User\Helpers;


use Tangibledesign\Framework\Models\Helpers\HasMeta;
use Tangibledesign\Framework\Models\Post\PostStatus;
use WP_Query;

/**
 * Trait HasFavorite
 * @package Tangibledesign\Framework\Models\User\Helpers
 */
trait HasFavorite
{
    use HasMeta;

    /**
     * @return array
     */
    public function getFavoriteIds(): array
    {
        $ids = $this->getMeta('favorite');
        if (!is_array($ids)) {
            return [];
        }

        return tdf_collect($ids)->map(static function ($id) {
            return (int)$id;
        })->values();
    }

    /**
     * @return int
     */
    public function getFavoriteNumber(): int
    {
        $favoriteIds = $this->getFavoriteIds();
        if (empty($favoriteIds)) {
            return 0;
        }

        $query = new WP_Query([
            'fields' => 'ids',
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'post_status' => PostStatus::PUBLISH,
            'post__in' => $favoriteIds,
        ]);

        return count($query->posts);
    }

    /**
     * @param array $ids
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setFavorites($ids): void
    {
        $this->setMeta('favorite', $ids);
    }

    /**
     * @param int $id
     * @noinspection PhpMissingParamTypeInspection
     */
    public function addFavorite($id): void
    {
        $ids = $this->getFavoriteIds();

        if (in_array($id, $ids, true)) {
            return;
        }

        $ids[] = $id;

        $this->setFavorites($ids);
    }

    /**
     * @param int $id
     * @noinspection PhpMissingParamTypeInspection
     */
    public function removeFavorite($id): void
    {
        $ids = $this->getFavoriteIds();

        if (!in_array($id, $ids, true)) {
            return;
        }

        unset($ids[array_search($id, $ids, true)]);

        $this->setFavorites($ids);
    }

}