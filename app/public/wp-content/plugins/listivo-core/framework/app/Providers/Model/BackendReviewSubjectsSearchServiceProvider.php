<?php

namespace Tangibledesign\Framework\Providers\Model;

use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Review;
use Tangibledesign\Framework\Models\User\User;

class BackendReviewSubjectsSearchServiceProvider extends ServiceProvider
{
    private const LIMIT = 10;

    public function afterInitiation(): void
    {
        add_action('admin_post_tdf/models/search', [$this, 'search']);
    }

    public function search(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        try {
            echo json_encode($this->getReviewSubjects(), JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            echo '';
        }
    }

    private function getReviewType(): string
    {
        return $_POST['reviewType'] ?? tdf_model_post_type();
    }

    private function getKeyword(): string
    {
        return $_POST['keyword'] ?? '';
    }

    private function getReviewSubjects(): array
    {
        $reviewType = $this->getReviewType();

        if ($reviewType === Review::TYPE_USER) {
            return $this->fetchUsers();
        }

        return $this->fetchModels();
    }

    private function fetchModels(): array
    {
        return tdf_query_models()
            ->search($this->getKeyword())
            ->take(self::LIMIT)
            ->get()
            ->map(static function ($reviewSubject) {
                /* @var Model $reviewSubject */
                return [
                    'id' => $reviewSubject->getId(),
                    'name' => $reviewSubject->getName(),
                ];
            })
            ->values();
    }

    private function fetchUsers(): array
    {
        return tdf_query_users()
            ->keyword($this->getKeyword())
            ->take(self::LIMIT)
            ->get()
            ->map(static function ($reviewSubject) {
                /* @var User $reviewSubject */
                return [
                    'id' => $reviewSubject->getId(),
                    'name' => $reviewSubject->getDisplayName(),
                ];
            })
            ->values();
    }
}