<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait AlignmentControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait AlignmentControl
{
    use Control;

    /**
     * @param string $selector
     * @param string $key
     */
    protected function addAlignmentControl(string $selector, string $key = 'alignment'): void
    {
        $this->add_responsive_control(
            $key,
            [
                'label' => tdf_admin_string('alignment'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => tdf_admin_string('left'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => tdf_admin_string('center'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => tdf_admin_string('right'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'text-align: {{VALUE}};',
                ],
            ]
        );
    }

}