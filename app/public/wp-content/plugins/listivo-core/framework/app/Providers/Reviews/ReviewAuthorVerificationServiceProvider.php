<?php

namespace Tangibledesign\Framework\Providers\Reviews;

use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class ReviewAuthorVerificationServiceProvider
 *
 * This service provider is responsible for verifying the author of a review.
 */
class ReviewAuthorVerificationServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_filter('wp_insert_post_data', [$this, 'verifyReviewAuthor'], 9999, 2);

    }

    /**
     * Verify the author of a review.
     *
     * If the post is a review and the author is not set or is a guest, set the author to 0 (guest).
     *
     * @param array $data The post data.
     * @param array $postArray The array of post fields.
     * @return array The modified post data.
     */
    public function verifyReviewAuthor(array $data, array $postArray): array
    {
        if ($data['post_type'] !== tdf_prefix() . '_review') {
            return $data;
        }

        $review = tdf_review_factory()->create($postArray['ID']);
        if (!$review) {
            return $data;
        }

        if ($review->isGuestReview()) {
            $data['post_author'] = 0;
        }

        return $data;
    }
}