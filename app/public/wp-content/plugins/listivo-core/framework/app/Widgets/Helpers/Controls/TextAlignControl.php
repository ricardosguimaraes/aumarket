<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait TextAlignControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait TextAlignControl
{
    use Control;

    /**
     * @param string $selector
     * @param string $key
     */
    public function addTextAlignControl(string $selector, string $key = 'text_align'): void
    {
        $this->add_responsive_control(
            $key . '_text_align',
            [
                'label' => tdf_admin_string('text_align'),
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
                    'justify' => [
                        'title' => tdf_admin_string('justify'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'text-align: {{VALUE}};',
                ],
            ]
        );
    }

}