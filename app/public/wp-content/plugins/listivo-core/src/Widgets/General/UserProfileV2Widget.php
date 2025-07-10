<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\UserControl;

class UserProfileV2Widget extends BaseGeneralWidget
{
    use UserControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_profile_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('User Profile V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addUserControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addDecorationControl();

        $this->endControlsSection();
    }

    private function addDecorationControl(): void
    {
        $this->add_control(
            'decoration',
            [
                'label' => esc_html__('Decoration', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    /**
     * @return bool
     */
    public function decorationEnabled(): bool
    {
        return !empty((int)$this->get_settings_for_display('decoration'));
    }

}