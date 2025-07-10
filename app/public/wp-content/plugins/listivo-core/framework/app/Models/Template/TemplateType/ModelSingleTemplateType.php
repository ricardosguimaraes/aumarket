<?php

namespace Tangibledesign\Framework\Models\Template\TemplateType;

use Elementor\Core\Base\Document;
use Elementor\Plugin;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Template\ModelSingleTemplate;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class ModelSingleTemplateType extends TemplateType
{
    public function getName(): string
    {
        return tdf_app('model_single_template_name');
    }

    public function getType(): string
    {
        return tdf_app('model_single_template_type');
    }

    public function isWidgetCompatible(string $widgetClass): bool
    {
        return is_a($widgetClass, ModelSingleWidget::class, true);
    }

    public function getTemplateClass(): string
    {
        return ModelSingleTemplate::class;
    }

    public function addElementorControls(Document $document): void
    {
        $document->add_control(
            'preview_listing',
            [
                'label' => tdf_admin_string('preview_model'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/model/list/keyword'),
            ]
        );
    }

    public function prepare(): void
    {
        global $post, ${tdf_short_prefix() . 'Model'};

        $model = tdf_post_factory()->create($post);
        if (!$model instanceof Model) {
            return;
        }

        ${tdf_short_prefix() . 'Model'} = $model;
    }

    public function preparePreview(): void
    {
        global ${tdf_short_prefix() . 'Model'};
        ${tdf_short_prefix() . 'Model'} = $this->getPreviewListing();
    }

    /**
     * @return Model|false
     */
    private function getPreviewListing()
    {
        $model = $this->getSelectedPreviewListing();

        if (!$model) {
            return $this->getDefaultPreviewListing();
        }

        return $model;
    }

    /**
     * @return Model|false
     */
    private function getSelectedPreviewListing()
    {
        global $post;
        if (!$post) {
            return false;
        }

        $document = Plugin::instance()->documents->get($post->ID);
        if (!$document) {
            return false;
        }

        $modelId = (int)$document->get_settings('preview_listing');
        if (empty($modelId)) {
            return false;
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return false;
        }

        return $model;
    }

    /**
     * @return Model|false
     */
    private function getDefaultPreviewListing()
    {
        $models = tdf_query_models()->anyStatus()->take(1)->get();

        return $models->isNotEmpty() ? $models->first() : false;
    }
}