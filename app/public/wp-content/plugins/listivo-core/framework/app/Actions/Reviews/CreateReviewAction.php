<?php

namespace Tangibledesign\Framework\Actions\Reviews;

use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\Review;

class CreateReviewAction
{
    public function execute(array $reviewData): void
    {
        $this->deleteIfNeed($reviewData);

        $this->create($reviewData);
    }

    private function deleteIfNeed(array $reviewData): void
    {
        if (!tdf_settings()->singleReviewPerModel()) {
            return;
        }

        if (is_user_logged_in()) {
            $this->deleteIfNeedForUser($reviewData);
            return;
        }

        $this->deleteIfNeedForGuest($reviewData);
    }

    private function deleteIfNeedForUser(array $reviewData): void
    {
        $currentUser = tdf_current_user();
        if (!$currentUser) {
            return;
        }

        $review = tdf_query_reviews()
            ->model($this->fetchModelId($reviewData), $this->fetchType($reviewData))
            ->userIn($currentUser->getId())
            ->anyStatus()
            ->first();

        if ($review instanceof Review) {
            $review->delete();
        }
    }

    private function deleteIfNeedForGuest(array $reviewData): void
    {
        $review = tdf_query_reviews()
            ->model($this->fetchModelId($reviewData), $this->fetchType($reviewData))
            ->in($this->getGuestReviewIds())
            ->anyStatus()
            ->first();

        if (!$review instanceof Review) {
            return;
        }

        $hash = $_COOKIE[tdf_prefix() . '/reviews/hash/' . $review->getId()] ?? '';
        if (empty($hash) || $review->getGuestHash() !== $hash) {
            return;
        }

        $review->delete();
    }

    private function getGuestReviewIds(): array
    {
        if (empty($_COOKIE[tdf_prefix() . '_reviews'])) {
            return [];
        }

        $reviewIds = explode(',', $_COOKIE[tdf_prefix() . '_reviews']);
        if (!is_array($reviewIds)) {
            return [];
        }

        return tdf_collect($reviewIds)
            ->map(static function ($reviewId) {
                return (int)$reviewId;
            })
            ->filter()
            ->values();
    }

    private function create(array $reviewData): void
    {
        $reviewId = wp_insert_post([
            'post_type' => tdf_prefix() . '_review',
            'post_content' => $this->fetchReview($reviewData),
            'post_author' => $this->fetchUserId(),
            'post_status' => $this->fetchStatus(),
            'meta_input' => [
                Review::RATING => $this->fetchRating($reviewData),
                Review::MODEL => $this->fetchModelId($reviewData),
                Review::IMAGES => $this->fetchImageIds($reviewData),
                Review::AUTHOR => $this->fetchAuthor($reviewData),
                Review::TYPE => $this->fetchType($reviewData),
            ],
        ]);

        if (!is_user_logged_in()) {
            $this->setGuestHash($reviewId);
        }
    }

    private function setGuestHash(int $reviewId): void
    {
        $review = tdf_review_factory()->create($reviewId);
        if (!$review) {
            return;
        }

        $hash = $review->generateGuestHash();

        setcookie(tdf_prefix() . '/reviews/hash/' . $reviewId, $hash, time() + (86400 * 30), '/');

        $reviewIds = $this->getGuestReviewIds();

        $reviewIds[] = $reviewId;

        setcookie(tdf_prefix() . '_reviews', implode(',', $reviewIds), time() + (86400 * 30), '/');
    }

    private function fetchReview(array $reviewData): string
    {
        return $reviewData['review'] ?? '';
    }

    private function fetchType(array $reviewData): string
    {
        return $reviewData['reviewType'] ?? tdf_model_post_type();
    }

    private function fetchStatus(): string
    {
        if (tdf_settings()->isReviewsModerationEnabled()) {
            return PostStatus::PENDING;
        }

        return PostStatus::PUBLISH;
    }

    private function fetchModelId(array $reviewData): int
    {
        return (int)($reviewData['modelId'] ?? 0);
    }

    private function fetchRating(array $reviewData): int
    {
        $rating = (int)($reviewData['rating'] ?? 1);
        if ($rating < 1) {
            return 0;
        }

        if ($rating > 5) {
            return 5;
        }

        return $rating;
    }

    private function fetchImageIds(array $reviewData): array
    {
        if (!tdf_settings()->reviewsImagesEnabled()) {
            return [];
        }

        $imageIds = $reviewData['images'] ?? [];

        if (!is_array($imageIds) || empty($imageIds)) {
            return [];
        }

        return tdf_collect($imageIds)
            ->map(static function ($imageId) {
                return (int)$imageId;
            })
            ->filter()
            ->values();
    }

    private function fetchUserId(): int
    {
        if (is_user_logged_in()) {
            return get_current_user_id();
        }

        return 0;
    }

    private function fetchAuthor(array $reviewData): string
    {
        if (is_user_logged_in()) {
            return '';
        }

        return $reviewData['author'] ?? '';
    }
}