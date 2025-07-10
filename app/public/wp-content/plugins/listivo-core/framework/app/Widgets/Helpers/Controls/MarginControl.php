<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;

trait MarginControl
{
    use Control;

    /**
     * @param string $selector
     * @return void
     */
    protected function addMarginControl(string $selector): void
    {
        $this->add_control(
            'margin',
            [
                'label' => tdf_admin_string('margin'),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
    }
}