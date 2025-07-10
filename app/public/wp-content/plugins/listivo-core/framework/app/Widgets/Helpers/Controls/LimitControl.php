<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;

/**
 * Trait LimitControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait LimitControl
{
    use Control;

    /**
     * @param string $label
     * @param int $default
     */
    protected function addLimitControl(string $label = '', int $default = 6): void
    {
        if (empty($label)) {
            $label = tdf_admin_string('limit');
        }

        $this->add_control(
            'limit',
            [
                'label' => $label,
                'type' => Controls_Manager::NUMBER,
                'default' => $default,
            ]
        );
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return (int)$this->get_settings_for_display('limit');
    }

}