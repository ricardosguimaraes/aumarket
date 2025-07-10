<?php

namespace Tangibledesign\Framework\Providers;

use Elementor\Plugin;
use JsonException;
use PhpParser\Node\Expr\AssignOp\Mod;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;

class CompareServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['compareModels'] = function () {
            return $this->fetchModels();
        };

        $this->container['compareModelsData'] = function () {
            return $this->formatModels($this->fetchModels());
        };
    }

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/compare/add', [$this, 'add']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/compare/add', [$this, 'add']);

        add_action('admin_post_' . tdf_prefix() . '/compare/remove', [$this, 'remove']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/compare/remove', [$this, 'remove']);

        add_action('admin_post_' . tdf_prefix() . '/compare/update', [$this, 'updateCompare']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/compare/update', [$this, 'updateCompare']);

        add_filter(tdf_prefix() . '/core/sharedState', [$this, 'addDataToSharedState']);

        add_action('wp_footer', [$this, 'loadPreviewTemplate']);
    }

    public function loadPreviewTemplate(): void
    {
        if (
            !empty($_GET['print'])
            || $this->isComparePage()
            || !tdf_settings()->isCompareModelsEnabled()
            || Plugin::instance()->editor->is_edit_mode()
        ) {
            return;
        }

        get_template_part('templates/partials/compare_preview');
    }

    public function addDataToSharedState(array $sharedState): array
    {
        if (!tdf_settings()->isCompareModelsEnabled()) {
            return $sharedState;
        }

        $models = $this->fetchModels();

        $sharedState['compareModels'] = $this->formatModels($models);
        $sharedState['compareModelIds'] = $models->map(static function ($model) {
            /* @var Model $model */
            return $model->getId();
        })->values();

        return $sharedState;
    }

    public function updateCompare(): void
    {
        if (!tdf_settings()->isCompareModelsEnabled()) {
            return;
        }

        $modelIds = $_POST['modelIds'];
        if (empty($modelIds) || !is_array($modelIds)) {
            $this->update(tdf_collect());

            $this->response(tdf_collect());
            return;
        }

        $models = tdf_query_models()->in($modelIds)->orderByIn()->get();

        $this->update($models);

        $this->response($models);
    }

    public function add(): void
    {
        if (!tdf_settings()->isCompareModelsEnabled()) {
            return;
        }

        $model = $this->fetchModel();
        if (!$model) {
            return;
        }

        $models = $this->fetchModels();
        $models->add($model);

        $this->update($models);

        $this->response($models);
    }

    public function remove(): void
    {
        if (!tdf_settings()->isCompareModelsEnabled()) {
            return;
        }

        $model = $this->fetchModel();
        if (!$model) {
            return;
        }

        $models = $this->fetchModels()->filter(static function ($cModel) use ($model) {
            /* @var Model $cModel */
            return $cModel->getId() !== $model->getId();
        });

        $this->update($models);

        $this->response($models);
    }

    private function update(Collection $models): void
    {
        try {
            setcookie($this->getCookieName(), json_encode($this->getModelIds($models), JSON_THROW_ON_ERROR),
                time() + (86400 * 30), "/");
        } catch (JsonException $e) {
        }
    }

    private function fetchModels(): Collection
    {
        $modelIds = $_COOKIE[$this->getCookieName()] ?? [];
        if (empty($modelIds)) {
            return tdf_collect();
        }

        try {
            $modelIds = json_decode($modelIds, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return tdf_collect();
        }

        if (!is_array($modelIds) || empty($modelIds)) {
            return tdf_collect();
        }

        return tdf_query_models()
            ->in($modelIds)
            ->orderByIn()
            ->get();
    }

    private function getCookieName(): string
    {
        return tdf_prefix() . '/compare';
    }

    private function fetchModel(): ?Model
    {
        $modelId = (int)($_POST['modelId'] ?? 0);
        if (empty($modelId)) {
            return null;
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return null;
        }

        return $model;
    }

    private function getModelIds(Collection $models): array
    {
        return array_unique($models->map(static function ($model) {
            /* @var Model $model */
            return $model->getId();
        })->values());
    }

    private function response(Collection $models): void
    {
        try {
            echo json_encode($this->formatModels($models), JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
        }
    }

    private function formatModels(Collection $models): array
    {
        return $models->map(static function ($model) {
            /* @var Model $model */
            return [
                'id' => $model->getId(),
                'name' => $model->getName(),
                'url' => $model->getUrl(),
                'image' => $model->getMainImageUrl(tdf_app('compare_model_image_size')),
            ];
        })->values();
    }
}