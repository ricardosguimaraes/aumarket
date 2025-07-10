<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\Widget;

abstract class BaseModelSingleWidget extends Widget implements ModelSingleWidget
{
    use HasModel;
    use HasVisibilitySection;

    public function get_categories(): array
    {
        return [tdf_prefix() . '_model'];
    }

    protected function getTemplateDirectory(): string
    {
        return 'model/';
    }

    public function getUserId(): int
    {
        $model = $this->getModel();
        if (!$model) {
            return 0;
        }

        return $model->getUserId();
    }

    /**
     * @return User|false
     */
    public function getUser()
    {
        return tdf_user_factory()->create($this->getUserId());
    }

    protected function render(): void
    {
        if (!$this->isVisible()) {
            return;
        }

        parent::render();
    }
}