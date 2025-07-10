<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;
use Tangibledesign\Framework\Models\Review;

class QueryReviews extends QueryPosts
{
    protected string $postType = 'review';

    protected bool $prefixPostType = true;

    public function getPostType(): string
    {
        return tdf_prefix() . '_review';
    }

    protected function getFactory(): BasePostFactory
    {
        return tdf_review_factory();
    }

    public function model(int $modelId, string $reviewType): QueryReviews
    {
        $this->metaQuery[] = [
            'key' => Review::MODEL,
            'value' => apply_filters(tdf_prefix() . '/query/reviews/model', $modelId, $reviewType),
        ];

        if ($reviewType === tdf_model_post_type()) {
            $this->metaQuery[] = [
                'relation' => 'OR',
                [
                    'key' => Review::TYPE,
                    'value' => $reviewType,
                ],
                [
                    'key' => Review::TYPE,
                    'compare' => 'NOT EXISTS'
                ]
            ];
        } else {
            $this->metaQuery[] = [
                'key' => Review::TYPE,
                'value' => $reviewType,
            ];
        }

        return $this;
    }

    public function orderByThumbUp(): QueryReviews
    {
        $this->orderByMeta(Review::THUMB_UP_COUNT);

        return $this;
    }

    public function filterByRating(int $rating): QueryReviews
    {
        $this->metaQuery[] = [
            'key' => Review::RATING,
            'value' => $rating,
        ];

        return $this;
    }
}