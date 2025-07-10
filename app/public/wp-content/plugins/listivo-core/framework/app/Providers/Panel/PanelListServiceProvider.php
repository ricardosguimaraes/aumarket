<?php


namespace Tangibledesign\Framework\Providers\Panel;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

/**
 * Class PanelListServiceProvider
 * @package Tangibledesign\Framework\Providers\Panel
 */
class PanelListServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/panel/list/models', [$this, 'models']);

        add_action('admin_post_'.tdf_prefix().'/panel/model/publish', [$this, 'publish']);
    }

    public function publish(): void
    {
        if (tdf_settings()->paymentsEnabled()) {
            return;
        }

        $modelId = (int) ($_GET['id'] ?? 0);
        if (empty($modelId)) {
            return;
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return;
        }

        if (!$model->isApproved() && tdf_settings()->moderationEnabled()) {
            $model->setPending();
        } elseif (!$model->isPublished()) {
            $model->setPublish();
        }

        wp_redirect(PanelWidget::getUrl(PanelWidget::ACTION_LIST));
        exit;
    }

    public function models(): void
    {
        $query = tdf_query_models()
            ->setStatus($this->getStatus())
            ->setPage($this->getPage())
            ->take($this->getLimit())
            ->search($this->getKeyword())
            ->userIn(get_current_user_id());

        if ($this->getOrderBy() === tdf_slug('newest')) {
            $query->orderByNewest();
        } elseif ($this->getOrderBy() === tdf_slug('oldest')) {
            $query->orderByOldest();
        }

        if (!current_user_can('manage_options')) {
            $query->userIn(get_current_user_id());
        }

        echo json_encode([
            'template' => $this->renderTemplate($query->get()),
            'count' => $query->getResultsNumber(),
        ]);
    }

    /**
     * @param  Collection  $models
     * @return string
     */
    private function renderTemplate(Collection $models): string
    {
        global ${tdf_short_prefix().'Models'};
        ${tdf_short_prefix().'Models'} = $models;

        ob_start();

        get_template_part('templates/widgets/general/panel/model_list');

        return ob_get_clean();
    }

    /**
     * @return string
     */
    private function getKeyword(): string
    {
        return trim($_POST['keyword']) ?? '';
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
        return (int) ($_POST['page'] ?? 1);
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