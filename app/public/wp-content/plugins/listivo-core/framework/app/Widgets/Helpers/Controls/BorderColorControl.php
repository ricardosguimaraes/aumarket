<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;

trait BorderColorControl
{
    use Control;

    /**
     * @param string $selector
     */
    protected function addBorderColorControl(string $selector): void
    {
        $this->add_control(
            'border_color',
            [
                'label' => tdf_admin_string('border_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'border-color: {{VALUE}};'
                ]
            ]
        );
    }

}