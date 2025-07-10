<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;

trait FlexAlignmentControl
{
    use Control;

    /**
     * @param string $selector
     */
    protected function addFlexAlignmentControl(string $selector): void
    {
        $this->add_responsive_control(
            'flex_alignment',
            [
                'label' => tdf_admin_string('alignment'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => tdf_admin_string('left'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => tdf_admin_string('center'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => tdf_admin_string('right'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'justify-content: {{VALUE}};'
                ]
            ]
        );
    }

}