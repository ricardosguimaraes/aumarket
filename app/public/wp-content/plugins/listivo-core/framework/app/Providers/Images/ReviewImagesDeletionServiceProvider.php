<?php

namespace Tangibledesign\Framework\Providers\Images;

use Tangibledesign\Framework\Core\ServiceProvider;
use WP_Post;

class ReviewImagesDeletionServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('before_delete_post', [$this, 'delete'], 10, 2);
    }

    public function delete($postId, WP_Post $post): void
    {
        if ($post->post_type !== tdf_review_post_type()) {
            return;
        }

        if (!tdf_settings()->deleteReviewImagesOnDelete()) {
            return;
        }

        $review = tdf_review_factory()->create($postId);
        if (!$review) {
            return;
        }

        $review->deleteImages();
    }
}