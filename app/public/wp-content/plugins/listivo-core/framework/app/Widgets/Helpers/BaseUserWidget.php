<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

use Tangibledesign\Framework\Widgets\Widget;

abstract class BaseUserWidget extends Widget implements UserWidget
{
    use HasUser, HasVisibilitySection;

    public function get_categories(): array
    {
        return [tdf_prefix() . '_user'];
    }

    protected function getTemplateDirectory(): string
    {
        return 'user/';
    }

    protected function render(): void
    {
        if (!$this->isVisible()) {
            return;
        }

        parent::render();
    }
}