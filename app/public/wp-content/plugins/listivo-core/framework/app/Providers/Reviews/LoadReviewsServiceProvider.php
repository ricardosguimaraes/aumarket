<?php

namespace Tangibledesign\Framework\Providers\Reviews;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\VerifyNonce;

class LoadReviewsServiceProvider extends ServiceProvider
{
    use VerifyNonce;

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/reviews/load', [$this, 'loadReviews']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/reviews/load', [$this, 'loadReviews']);
    }

    public function loadReviews(): void
    {
        $nonce = $_POST['nonce'] ?? '';
        if (empty($nonce)) {
            wp_send_json_error('No nonce');
            return;
        }

        if (!$this->verifyNonce($_POST['nonce'], tdf_prefix() . '/reviews/load')) {
            wp_send_json_error('Invalid nonce');
            return;
        }

        $query = tdf_query_reviews()
            ->model($this->getModelId(), $this->getReviewType())
            ->take($this->getLimit())
            ->skip($this->getOffset());

        $orderBy = $this->getOrderBy();

        if ($orderBy === 'oldest') {
            $query->orderByOldest();
        } elseif ($orderBy === 'most_helpful') {
            $query->orderByThumbUp();
        } else {
            $query->orderByNewest();
        }

        $filterRating = $this->getFilterRating();

        if (!empty($filterRating)) {
            $query->filterByRating($filterRating);
        }

        $reviews = $query->get();

        ob_start();

        global ${tdf_short_prefix() . 'Review'};
        foreach ($reviews as ${tdf_short_prefix() . 'Review'}) {
            /** @noinspection DisconnectedForeachInstructionInspection */
            get_template_part($this->getTemplate(), null, [
                'isModal' => true,
            ]);
        }

        echo json_encode([
            'template' => ob_get_clean(),
            'totalPages' => ceil($query->getResultsNumber() / $this->getLimit()),
        ], JSON_THROW_ON_ERROR);
    }

    private function getTemplate():string
    {
        return apply_filters('tdf/reviews/load/template', 'templates/partials/review');
    }

    private function getPage(): int
    {
        return (int)($_POST['page'] ?? 1);
    }

    private function getLimit(): int
    {
        return (int)($_POST['limit'] ?? 10);
    }

    private function getModelId(): int
    {
        return (int)($_POST['modelId'] ?? 0);
    }

    private function getOrderBy(): string
    {
        return $_POST['sortBy'] ?? 'newest';
    }

    private function getFilterRating(): int
    {
        return (int)($_POST['filterRating'] ?? 0);
    }

    private function getReviewType(): string
    {
        return $_POST['reviewType'] ?? tdf_model_post_type();
    }

    private function getOffset(): int
    {
        return $this->getPage() * $this->getLimit() - $this->getLimit();
    }
}