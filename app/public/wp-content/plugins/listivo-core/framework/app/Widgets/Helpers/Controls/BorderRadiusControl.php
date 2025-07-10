<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;

trait BorderRadiusControl
{
    use Control;

    protected function addBorderRadiusControl(string $selector, string $key = 'border_radius'): void
    {
        $this->add_responsive_control(
            $key,
            [
                'label' => tdf_admin_string('border_radius'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }
}