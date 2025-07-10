<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class CallToActionSectionV2Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use ButtonControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'call_to_action_section_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Call To Action Section V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addBackgroundImageControl();

        $this->addHeadingControls();

        $this->addButtonControls();

        $this->endControlsSection();
    }

    private function addBackgroundImageControl(): void
    {
        $this->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getBackgroundImage(): string
    {
        $image = $this->get_settings_for_display('background_image');

        return $image['url'] ?? '';
    }

}