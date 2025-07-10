<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait ButtonTypeControl
{
    use Control;

    /**
     * @param string $default
     * @param string $label
     * @param array $settings
     * @return void
     */
    protected function addButtonTypeControl(string $default = 'primary_1', string $label = '', array $settings = []): void
    {
        if (empty($label)) {
            $label = esc_html__('Button type', 'listivo-core');
        }

        $this->add_control(
            'button_type',
            [
                'label' => $label,
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'primary_1' => esc_html__('Primary 1', 'listivo-core'),
                    'primary_2' => esc_html__('Primary 2', 'listivo-core'),
                ],
                'default' => $default,
            ] + $settings,
        );
    }

    /**
     * @return bool
     */
    public function isPrimary1ButtonType(): bool
    {
        return $this->get_settings_for_display('button_type') === 'primary_1';
    }

    /**
     * @return bool
     */
    public function isPrimary2ButtonType(): bool
    {
        return $this->get_settings_for_display('button_type') === 'primary_2';
    }

}