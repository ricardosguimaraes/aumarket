<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Group_Control_Typography;

trait TypographyControl
{
    use Control;

    /**
     * @param string $selector
     * @param string $key
     */
    public function addTypographyControl(string $selector, string $key = 'typography'): void
    {
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => tdf_admin_string('typography'),
                'name' => $key . '_typography',
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );
    }

}