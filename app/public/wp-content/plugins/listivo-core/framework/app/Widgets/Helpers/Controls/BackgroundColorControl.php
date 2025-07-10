<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait BackgroundColorControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait BackgroundColorControl
{
    use Control;

    /**
     * @param string $selector
     * @param string $key
     */
    protected function addBackgroundColorControl(string $selector, string $key = 'background_color'): void
    {
        $this->add_control(
            $key,
            [
                'label' => tdf_admin_string('background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'background-color: {{VALUE}};'
                ]
            ]
        );
    }

}
