<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;

trait JustifyContentResponsiveControl
{
    use Control;

    /**
     * @param string $selector
     * @param string $label
     */
    protected function addJustifyContentControl(string $selector, string $label = ''): void
    {
        if (empty($label)) {
            $label = tdf_admin_string('alignment');
        }

        $this->add_responsive_control(
            'justify_content',
            [
                'label' => $label,
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
                    '{{WRAPPER}} ' . $selector => 'justify-content: {{VALUE}} !important;',
                ],
            ]
        );
    }
}