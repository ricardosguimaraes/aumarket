<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait WidthControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait WidthControl
{
    use Control;

    /**
     * @param string $selector
     * @param int $default
     */
    protected function addMaxWidthControl(string $selector, int $default = 600): void
    {
        $this->add_responsive_control(
            'width',
            [
                'label' => tdf_admin_string('width'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'width: {{SIZE}}{{UNIT}};'
                ],
                'default' => [
                    'size' => $default,
                    'unit' => 'px'
                ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
            ]
        );
    }
}