<?php

namespace Tangibledesign\Framework\Providers\Reviews;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Review;

class ReviewThumbServiceProvider extends ServiceProvider
{
    private const THUMB_UP = 1;
    private const THUMB_DOWN = -1;
    private const THUMB_NONE = 0;

    public function afterInitiation(): void
    {
        add_action('admin_post_nopriv_' . tdf_prefix() . '/review/thumb', [$this, 'reviewThumb']);
        add_action('admin_post_' . tdf_prefix() . '/review/thumb', [$this, 'reviewThumb']);
    }

    public function reviewThumb(): void
    {
        $this->verifyNonce();

        if (!tdf_settings()->reviewsThumbsEnabled()) {
            return;
        }

        $this->validateRequest();

        $reviewId = (int)$_POST['reviewId'];
        $thumb = (int)$_POST['thumb'];

        $review = tdf_review_factory()->create($reviewId);
        if (!$review) {
            wp_send_json_error();
        }

        if ($thumb === self::THUMB_UP) {
            $review->increaseThumbUpCount();
        } elseif ($thumb === self::THUMB_DOWN) {
            $review->increaseThumbDownCount();
        }

        $this->adjustReviewThumbsCountFromCookie($review);

        setcookie(
            tdf_prefix() . '/review/thumb/' . $review->getId(),
            $thumb,
            time() + 60 * 60 * 24 * 30 * 12,
            COOKIEPATH,
            COOKIE_DOMAIN,
            false,
            true
        );
    }

    private function adjustReviewThumbsCountFromCookie(Review $review): void
    {
        $cookieValue = $this->getCookieValue($review->getId());
        if ($cookieValue === self::THUMB_NONE) {
            return;
        }

        if ($cookieValue === self::THUMB_UP) {
            $review->decreaseThumbUpCount();
        } elseif ($cookieValue === self::THUMB_DOWN) {
            $review->decreaseThumbDownCount();
        }
    }

    private function getCookieValue(int $reviewId): int
    {
        $cookieKey = tdf_prefix() . '/review/thumb/' . $reviewId;
        if (empty($_COOKIE[$cookieKey])) {
            return self::THUMB_NONE;
        }

        return (int)$_COOKIE[$cookieKey];
    }

    private function verifyNonce(): void
    {
        if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], tdf_prefix() . '/review/thumb')) {
            wp_send_json_error();
        }
    }

    private function validateRequest(): void
    {
        if (!isset($_POST['reviewId'], $_POST['thumb'])) {
            wp_send_json_error();
        }
    }
}