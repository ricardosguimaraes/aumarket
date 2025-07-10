<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;

trait IconControl
{
    use Control;

    protected function addIconControl(): void
    {
        $this->add_control(
            'icon',
            [
                'label' => tdf_admin_string('icon'),
                'type' => Controls_Manager::ICONS,
            ]
        );
    }

    public function getIcon(): string
    {
        $icon = $this->get_settings_for_display('icon');

        if ($icon['library'] === 'svg') {
            return $icon['value']['url'] ?? '';
        }

        return $icon['value'] ?? '';
    }

    public function getIconType(): string
    {
        $icon = $this->get_settings_for_display('icon');
        return $icon['library'];
    }

    public function isSvgIcon(): bool
    {
        return $this->getIconType() === 'svg';
    }
}