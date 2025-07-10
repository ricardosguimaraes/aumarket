<?php

namespace Tangibledesign\Framework\Interfaces;

use Tangibledesign\Framework\Core\Collection;

interface HasReviewsInterface
{
    public function getId(): int;

    public function getReviews(int $page, int $limit = 10): Collection;

    public function getReviewCountByRating(int $rating): int;

    public function getReviewNumber(): int;

    public function getRating(): string;

    public function getRawRating(): float;
}