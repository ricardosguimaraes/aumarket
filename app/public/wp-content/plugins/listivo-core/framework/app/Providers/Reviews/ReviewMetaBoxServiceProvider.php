<?php

namespace Tangibledesign\Framework\Providers\Reviews;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Review;
use WP_Post;

class ReviewMetaBoxServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('add_meta_boxes', [$this, 'addMetaBox'], 10, 2);
        add_action('save_post', [$this, 'saveMetaBox'], 10, 2);
    }

    public function saveMetaBox(int $postId, WP_Post $post): void
    {
        if (wp_is_post_revision($post) || tdf_prefix() . '_review' !== $post->post_type) {
            return;
        }

        if (!wp_verify_nonce($_POST[tdf_prefix() . '_nonce'] ?? '', tdf_prefix() . '/review/update')) {
            return;
        }

        $review = tdf_review_factory()->create($post);
        if (!$review) {
            return;
        }

        $review->setRating((int)($_POST[Review::RATING] ?? 0));
        $review->setImageIds($_POST['gallery'] ?? []);
        $review->setThumbUpCount((int)($_POST[Review::THUMB_UP_COUNT] ?? 0));
        $review->setThumbDownCount((int)($_POST[Review::THUMB_DOWN_COUNT] ?? 0));
        $review->setAuthor($_POST[Review::AUTHOR] ?? '');
        $review->setModelId((int)($_POST[Review::MODEL] ?? 0));
        $review->setType($_POST[Review::TYPE] ?? tdf_model_post_type());
    }

    public function addMetaBox(string $postType, $post): void
    {
        if (
            !$post instanceof WP_Post
            || empty($post->post_status)
            || $postType !== tdf_prefix() . '_review'
        ) {
            return;
        }

        $this->createForm($post);
    }

    public function createForm(WP_Post $post): void
    {
        $review = tdf_review_factory()->create($post);
        if (!$review) {
            return;
        }

        add_meta_box('tdf-review', tdf_admin_string('review'), static function () use ($review) {
            tdf_load_view('review/meta-box', [
                tdf_short_prefix() . 'Review' => $review,
            ]);
        }, null, 'normal', 'high');
    }
}