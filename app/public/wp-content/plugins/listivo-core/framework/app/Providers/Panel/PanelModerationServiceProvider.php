<?php

namespace Tangibledesign\Framework\Providers\Panel;

use Tangibledesign\Framework\Actions\PaymentPackage\ApplyPackageAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Post\PostStatus;

class PanelModerationServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/panel/moderation/models', [$this, 'models']);
        add_action('admin_post_' . tdf_prefix() . '/panel/moderation/approve', [$this, 'approve']);
        add_action('admin_post_' . tdf_prefix() . '/panel/moderation/decline', [$this, 'decline']);
        add_action('admin_post_' . tdf_prefix() . '/panel/moderation/publish', [$this, 'publish']);
        add_action('admin_post_' . tdf_prefix() . '/panel/moderation/delete', [$this, 'delete']);
        add_action('admin_post_' . tdf_prefix() . '/panel/moderation/draft', [$this, 'draft']);
    }

    public function approve(): void
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!tdf_current_user()->isModerator()) {
            return;
        }

        $modelId = $this->getModelId();
        if (!$this->verifyModerationNonce($modelId)) {
            return;
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return;
        }

        /** @noinspection NotOptimalIfConditionsInspection */
        if (
            tdf_settings()->paymentsEnabled()
            && (
                ($model->getExpireDate() !== 'unlimited' && !$model->hasExpireDate())
                || $model->hasPendingPackage()
            )
            && !$this->applyPackage($model)
        ) {
            $this->errorJsonResponse([
                'title' => tdf_string('error'),
                'text' => tdf_string('error_no_package_listing'),
            ]);
            return;
        }

        if ($model->hasPendingPackage() && tdf_settings()->paymentsEnabled()) {
            $model->removePendingPackage();
        }

        $args = [
            'ID' => $modelId,
            'post_status' => PostStatus::PUBLISH,
        ];

        if ((!$model->hasExpireDate() && tdf_settings()->paymentsEnabled()) || ($model->shouldUpdatePublishDate() && !tdf_settings()->paymentsEnabled())) {
            $date = current_time('mysql');
            $dateGmt = get_gmt_from_date($date);

            $args['post_date'] = $date;
            $args['post_date_gmt'] = $dateGmt;
        }

        wp_update_post($args);

        if ($this->setExpireDate($model)) {
            $model->setExpireDateFromDays(tdf_settings()->getListingExpireAfter());
        }

        $model->setApproved(1);

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::MODEL_APPROVED, [
            'user' => $model->getUserId(),
            'model' => $model->getId(),
        ]);

        $this->successJsonResponse();
    }

    private function setExpireDate(Model $model): bool
    {
        return !$model->hasExpireDate()
            && !tdf_settings()->paymentsEnabled()
            && !empty(tdf_settings()->getListingExpireAfter());
    }

    /**
     * @param Model $model
     * @return bool
     */
    private function applyPackage(Model $model): bool
    {
        if (!$model->hasPendingPackage()) {
            return false;
        }

        $package = $model->getPendingPackage();
        if (!$package) {
            return false;
        }

        return (new ApplyPackageAction())->apply($package, $model, false);
    }

    public function decline(): void
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!tdf_current_user()->isModerator()) {
            return;
        }

        $modelId = $this->getModelId();
        if (!$this->verifyModerationNonce($modelId)) {
            return;
        }

        $message = $_POST['message'] ?? '';

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return;
        }

        /** @noinspection NotOptimalIfConditionsInspection */
        if (tdf_settings()->paymentsEnabled() && $model->hasPendingPackage()) {
            $package = $model->getPendingPackage();
            $user = $model->getUser();
            if ($package && $user) {
                $user->increasePackage($package->getId());
            }

            $model->removePendingPackage();
        }

        wp_update_post([
            'ID' => $modelId,
            'post_status' => PostStatus::DRAFT,
        ]);

        do_action(tdf_prefix() . '/notifications/trigger', Trigger::MODEL_DECLINED, [
            'user' => $model->getUserId(),
            'model' => $model->getId(),
            'additional' => [
                'message' => $message,
            ],
        ]);

    }

    public function publish(): void
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!tdf_current_user()->isModerator()) {
            return;
        }

        $modelId = $this->getModelId();

        if (!$this->verifyModerationNonce($modelId)) {
            return;
        }

        wp_update_post([
            'ID' => $modelId,
            'post_status' => PostStatus::PUBLISH,
        ]);
    }

    public function draft(): void
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!tdf_current_user()->isModerator()) {
            return;
        }

        $modelId = $this->getModelId();

        if (!$this->verifyModerationNonce($modelId)) {
            return;
        }

        $model = tdf_model_factory()->create($modelId);
        if (!$model) {
            return;
        }

        $model->setDraft();
    }

    public function delete(): void
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!tdf_current_user()->isModerator()) {
            return;
        }

        $modelId = $this->getModelId();

        if (!$this->verifyModerationNonce($modelId)) {
            return;
        }

        wp_delete_post($modelId, true);
    }

    /**
     * @return int
     */
    private function getModelId(): int
    {
        return (int)($_POST['modelId'] ?? 0);
    }

    /**
     * @param int $modelId
     * @return bool
     */
    private function verifyModerationNonce(int $modelId): bool
    {
        return wp_verify_nonce($_POST['nonce'] ?? '', tdf_prefix() . '_moderation_' . $modelId);
    }

    public function models(): void
    {
        $query = tdf_query_models()
            ->setStatus($this->getStatus())
            ->setPage($this->getPage())
            ->take($this->getLimit())
            ->search($this->getKeyword());

        if ($this->getOrderBy() === tdf_slug('newest')) {
            $query->orderByNewest();
        } elseif ($this->getOrderBy() === tdf_slug('oldest')) {
            $query->orderByOldest();
        }

        /** @noinspection JsonEncodingApiUsageInspection */
        echo json_encode([
            'template' => $this->renderTemplate($query->get()),
            'count' => $query->getResultsNumber(),
        ]);
    }

    /**
     * @param Collection $models
     * @return string
     */
    private function renderTemplate(Collection $models): string
    {
        global ${tdf_short_prefix() . 'Models'};
        ${tdf_short_prefix() . 'Models'} = $models;

        ob_start();

        get_template_part('templates/widgets/general/panel/moderation_list');

        return ob_get_clean();
    }

    /**
     * @return string
     */
    private function getKeyword(): string
    {
        return trim($_POST['keyword'] ?? '');
    }

    /**
     * @return int
     */
    private function getLimit(): int
    {
        return 10;
    }

    /**
     * @return int
     */
    private function getPage(): int
    {
        return (int)($_POST['page'] ?? 1);
    }

    /**
     * @return string
     */
    private function getStatus(): string
    {
        return $_POST['status'] ?? 'any';
    }

    /**
     * @return string
     */
    private function getOrderBy(): string
    {
        return $_POST['sortBy'] ?? 'newest';
    }

}