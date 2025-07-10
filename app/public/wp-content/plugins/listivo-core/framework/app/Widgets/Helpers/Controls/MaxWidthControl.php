<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait MaxWidthControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait MaxWidthControl
{
    use Control;

    /**
     * @param string $selector
     * @param int $default
     */
    protected function addMaxWidthControl(string $selector, int $default = 600): void
    {
        $this->add_responsive_control(
            'max_width',
            [
                'label' => tdf_admin_string('max_width'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'max-width: {{SIZE}}{{UNIT}};'
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