<?php


namespace Tangibledesign\Listivo\Widgets\User;


use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\PostSingleWidget;

/**
 * Class UserRegisteredSinceWidget
 * @package Tangibledesign\Listivo\Widgets\User
 */
class UserRegisteredSinceWidget extends BaseUserWidget implements ModelSingleWidget, PostSingleWidget
{
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_registered_since';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('User Registered Since', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextControls('.listivo-user-date');

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

}