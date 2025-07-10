<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ImageControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextareaControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class ContentV6Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use TextareaControl;
    use ButtonControls;
    use ImageControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'content_v6';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Content section V6', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addImageControl();

        $this->addAwardControls();

        $this->addHeadingControls();

        $this->addTextControl();

        $this->addButtonControls('primary_2');

        $this->endControlsSection();

        $this->addHeadingStyleSection();
    }

    private function addAwardControls(): void
    {
        $this->add_control(
            'award_heading',
            [
                'label' => esc_html__('Info box', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'award_image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'award_value',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'award_text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getAwardImage(): string
    {
        $image = $this->get_settings_for_display('award_image');

        return $image['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getAwardValue(): string
    {
        return (string)$this->get_settings_for_display('award_value');
    }

    /**
     * @return string
     */
    public function getAwardText(): string
    {
        return (string)$this->get_settings_for_display('award_text');
    }

}