<?php

namespace Tangibledesign\Framework\Traits;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Helpers\HasMeta;
use Tangibledesign\Framework\Models\Review;

trait HasReviewsTrait
{
    use HasMeta;

    abstract public function getId(): int;

    abstract public function getReviewType(): string;

    public function getReviewNumber(): int
    {
        $cacheKey = tdf_prefix() . '/reviews/' . $this->getReviewType() . '/number/' . $this->getId();
        $cachedNumber = get_transient($cacheKey);

        if ($cachedNumber !== false) {
            return apply_filters(tdf_prefix() . '/reviews/number', $cachedNumber, $this->getId(), $this->getReviewType());
        }

        $number = tdf_query_reviews()
            ->model($this->getId(), $this->getReviewType())
            ->getResultsNumber();

        set_transient($cacheKey, $number, 60 * 60 * 24);

        return apply_filters(tdf_prefix() . '/reviews/number', $number, $this->getId(), $this->getReviewType());
    }

    public function getReviewCountByRating(int $rating): int
    {
        return tdf_query_reviews()
            ->model($this->getId(), $this->getReviewType())
            ->filterByRating($rating)
            ->getResultsNumber();
    }

    public function getReviews(int $page = 1, int $limit = 10): Collection
    {
        return tdf_query_reviews()
            ->model($this->getId(), $this->getReviewType())
            ->take($limit)
            ->skip($page * $limit - $limit)
            ->orderByNewest()
            ->get();
    }

    public function getRawRating(): float
    {
        $cacheKey = tdf_prefix() . '/reviews/' . $this->getReviewType() . '/rating/' . $this->getId();
        $cachedRating = get_transient($cacheKey);

        if ($cachedRating !== false) {
            return (float)apply_filters(tdf_prefix() . '/reviews/rating', $cachedRating, $this->getId(), $this->getReviewType());
        }

        $rating = $this->calculateRating();

        set_transient($cacheKey, $rating, 60 * 60 * 24);

        return (float)apply_filters(tdf_prefix() . '/reviews/rating', $rating, $this->getId(), $this->getReviewType());
    }

    public function getRating(): string
    {
        return number_format($this->getRawRating(), 1, tdf_settings()->getDecimalSeparator(), '');
    }

    private function calculateRating(): float
    {
        $rating = tdf_query_reviews()
            ->model($this->getId(), $this->getReviewType())
            ->get()
            ->average(static function ($review) {
                /** @var Review $review */
                return $review->getRating();
            });

        return round($rating, 1);
    }
}