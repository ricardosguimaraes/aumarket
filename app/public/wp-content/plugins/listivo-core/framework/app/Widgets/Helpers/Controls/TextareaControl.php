<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;

trait TextareaControl
{
    use Control;

    protected function addTextControl(string $default = ''): void
    {
        $this->add_control(
            'text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => $default,
            ]
        );
    }

    public function getText(): string
    {
        return (string)$this->get_settings_for_display('text');
    }
}