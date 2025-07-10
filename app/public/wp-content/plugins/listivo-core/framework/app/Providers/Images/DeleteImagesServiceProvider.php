<?php

namespace Tangibledesign\Framework\Providers\Images;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\AttachmentsField;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Review;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use WP_Query;

class DeleteImagesServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['imagesToDeleteCount'] = function () {
            return $this->count();
        };
    }

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/images/cleanUp', [$this, 'cleanUp']);
    }

    public function cleanUp(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        foreach ($this->getImages() as $imageId) {
            wp_delete_attachment($imageId, true);
        }

        wp_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_advanced&tab=tools'));
        exit;
    }

    private function getModelIds(): array
    {
        $query = new WP_Query([
            'post_type' => tdf_model_post_type(),
            'posts_per_page' => -1,
            'post_status' => 'any',
            'fields' => 'ids',
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);

        return $query->posts;
    }

    private function getReviewIds(): array
    {
        $query = new WP_Query([
            'post_type' => tdf_review_post_type(),
            'posts_per_page' => -1,
            'post_status' => 'any',
            'fields' => 'ids',
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);

        return $query->posts;
    }

    /**
     * @noinspection SqlDialectInspection
     * @noinspection SqlNoDataSourceInspection
     */
    private function getUserImageIds(): array
    {
        global $wpdb;

        $results = $wpdb->get_results("
            SELECT meta_value 
            FROM $wpdb->usermeta 
            WHERE meta_key = '" . UserSettingKey::IMAGE . "' 
            AND meta_value != ''"
        );

        $imageIds = [];

        foreach ($results as $meta) {
            $imageIds[] = (int)$meta->meta_value;
        }

        return $imageIds;
    }

    public function count(): int
    {
        return count($this->getImages());
    }

    /** @noinspection PhpConditionAlreadyCheckedInspection */
    public function getImages(): array
    {
        $imageIds = [];

        foreach ($this->getModelIds() as $modelId) {
            foreach (tdf_gallery_fields() as $galleryField) {
                /* @var GalleryField $galleryField */
                $modelImageIds = get_post_meta($modelId, $galleryField->getKey(), true);
                if (!is_array($modelImageIds)) {
                    continue;
                }

                $imageIds = [...$imageIds, ...$modelImageIds];
            }

            foreach (tdf_attachment_fields() as $attachmentField) {
                /* @var AttachmentsField $attachmentField */
                $modelImageIds = get_post_meta($modelId, $attachmentField->getKey(), true);
                if (!is_array($modelImageIds)) {
                    continue;
                }

                $imageIds = [...$imageIds, ...$modelImageIds];
            }
        }

        foreach ($this->getReviewIds() as $reviewId) {
            $reviewImageIds = get_post_meta($reviewId, Review::IMAGES, true);
            if (!is_array($reviewImageIds)) {
                continue;
            }

            $imageIds = [...$imageIds, ...$reviewImageIds];
        }

        $imageIds = [...$imageIds, ...$this->getUserImageIds()];

        $imageIds = array_unique($imageIds);

        $query = new WP_Query([
            'post__not_in' => $imageIds,
            'meta_query' => [
                'relation' => 'OR',
                [
                    'key' => tdf_prefix() . '_source',
                    'value' => 'panel',
                ],
                [
                    'key' => tdf_prefix() . '_source',
                    'value' => 'review',
                ],
                [
                    'key' => tdf_prefix() . '_source',
                    'value' => 'user_profile',
                ]
            ],
            'posts_per_page' => -1,
            'post_type' => 'attachment',
            'post_status' => 'any',
            'fields' => 'ids',
            'update_post_meta_cache' => false,
            'update_post_term_cache' => false,
        ]);

        return $query->posts;
    }
}