<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;

trait TextControl
{
    use Control;

    public function addTextControl(string $label = 'Text'): void
    {
        $this->add_control(
            'text',
            [
                'label' => $label,
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return (string)$this->get_settings_for_display('text');
    }

}