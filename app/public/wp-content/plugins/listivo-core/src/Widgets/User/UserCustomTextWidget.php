<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;

class UserCustomTextWidget extends BaseUserWidget implements ModelSingleWidget
{
    use HasModel, TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_custom_text';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Custom Text', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::WYSIWYG,
            ]
        );

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addTextControls('.listivo-user-custom-text');

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return (string) $this->get_settings_for_display('text');
    }

}