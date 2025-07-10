<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait TextColorControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait TextColorControl
{
    use Control;

    /**
     * @param string $selector
     * @param string $key
     * @param string $label
     */
    protected function addTextColorControl(string $selector, string $key = 'color', string $label = ''): void
    {
        if (empty($label)) {
            $label = tdf_admin_string('color');
        }

        $this->add_control(
            $key . '_color',
            [
                'label' => $label,
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}};'
                ]
            ]
        );
    }

}