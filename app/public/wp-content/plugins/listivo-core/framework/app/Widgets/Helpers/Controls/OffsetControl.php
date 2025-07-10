<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait OffsetControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait OffsetControl
{
    use Control;

    protected function addOffsetControl(): void
    {
        $this->add_control(
            'offset',
            [
                'label' => tdf_admin_string('offset'),
                'type' => Controls_Manager::NUMBER,
                'default' => 0,
            ]
        );
    }

    /**
     * @return int
     */
    protected function getOffset(): int
    {
        return (int)$this->get_settings_for_display('offset');
    }

}