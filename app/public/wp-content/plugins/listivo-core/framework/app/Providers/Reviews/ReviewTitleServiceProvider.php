<?php

namespace Tangibledesign\Framework\Providers\Reviews;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Review;
use Tangibledesign\Framework\Models\User\User;

class ReviewTitleServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_filter('the_title', [$this, 'filterTitle'], 10, 2);
    }

    public function filterTitle(string $title, int $postId): string
    {
        if (get_post_type($postId) !== tdf_prefix() . '_review') {
            return $title;
        }

        $review = tdf_review_factory()->create($postId);
        if (!$review instanceof Review) {
            return $title;
        }

        $model = $review->getModel();
        if (!$model) {
            return $title;
        }

        if ($model instanceof Model) {
            return $this->createTitle($model->getName(), $review->getRating(), $this->getAuthorName($review));
        }

        if ($model instanceof User) {
            return $this->createTitle($model->getDisplayName(), $review->getRating(), $this->getAuthorName($review));
        }

        return $title;
    }

    private function getAuthorName(Review $review): string
    {
        $author = $review->getAuthor();
        if (!empty($author)) {
            return $author;
        }

        $user = $review->getUser();
        if (!$user) {
            return '';
        }

        return $user->getDisplayName();
    }

    private function createTitle(string $modelName, float $rating, $author): string
    {
        return $modelName . ' (' . $rating . '/5) ' . $author;
    }
}