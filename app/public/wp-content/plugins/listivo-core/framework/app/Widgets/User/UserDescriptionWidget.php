<?php

namespace Tangibledesign\Framework\Widgets\User;

use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;
use Tangibledesign\Framework\Widgets\Helpers\PostSingleWidget;

class UserDescriptionWidget extends BaseUserWidget implements PostSingleWidget
{
    use TextControls;

    public function getKey(): string
    {
        return 'user_description';
    }

    public function getName(): string
    {
        return tdf_admin_string('user_description');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextControls($this->getSelector());

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function getSelector(): string
    {
        return '.' . tdf_prefix() . '-user-description';
    }
}