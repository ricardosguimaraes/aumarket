<?php


namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

/**
 * Trait HeadingControls
 * @package Tangibledesign\Listivo\Widgets\Helpers\Controls
 */
trait HeadingControls
{
    use Control;

    protected function addHeadingControls(): void
    {
        $this->add_control(
            'small_text',
            [
                'label' => esc_html__('Small Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getSmallText(): string
    {
        return (string)$this->get_settings_for_display('small_text');
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return (string)$this->get_settings_for_display('text');
    }

}