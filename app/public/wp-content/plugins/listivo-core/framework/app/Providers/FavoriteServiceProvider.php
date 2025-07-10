<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;

/**
 * Class FavoriteServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class FavoriteServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/favorite/add', [$this, 'add']);

        add_action('admin_post_' . tdf_prefix() . '/favorite/add', [$this, 'remove']);

        add_action('admin_post_' . tdf_prefix() . '/favorite/update', [$this, 'update']);
    }

    public function update(): void
    {
        $ids = $_POST['favorite'] ?? [];
        $user = tdf_current_user();
        $modelId = $_POST['modelId'] ?? '';

        if (!is_array($ids) || !$user) {
            $ids = [];
        }

        if (!empty($modelId)) {
            if (in_array($modelId, $ids, true)) {
                $this->increaseCounter($modelId);
            } else {
                $this->decreaseCounter($modelId);
            }
        }

        $user->setFavorites($ids);
    }

    public function add(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        if (empty($id) || !tdf_current_user()) {
            return;
        }

        /** @noinspection NullPointerExceptionInspection */
        tdf_current_user()->addFavorite($id);
    }

    public function remove(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        if (empty($id) || !tdf_current_user()) {
            return;
        }

        /** @noinspection NullPointerExceptionInspection */
        tdf_current_user()->removeFavorite($id);
    }

    /**
     * @param int $modelId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function increaseCounter($modelId): void
    {
        $counter = (int)get_post_meta($modelId, Model::FAVORITE_COUNT, true);
        update_post_meta($modelId, Model::FAVORITE_COUNT, ++$counter);
    }

    /**
     * @param int $modelId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function decreaseCounter($modelId): void
    {
        $counter = (int)get_post_meta($modelId, Model::FAVORITE_COUNT, true);
        if ($counter > 0) {
            update_post_meta($modelId, Model::FAVORITE_COUNT, --$counter);
        }
    }

}