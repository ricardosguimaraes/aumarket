<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

trait SimpleLabelControl
{
    use Control;

    protected function addLabelControl(string $default = '', string $label = ''): void
    {
        if (empty($label)) {
            $label = tdf_admin_string('label');
        }

        $this->add_control(
            'label',
            [
                'label' => $label,
                'type' => Controls_Manager::TEXT,
                'default' => $default,
            ]
        );
    }

    public function hasLabel(): bool
    {
        return !empty($this->getLabel());
    }

    public function getLabel(): string
    {
        return (string)$this->get_settings_for_display('label');
    }

    protected function addLabelStyleControls(string $selector, bool $withHeading = true): void
    {
        if ($withHeading) {
            $this->add_control(
                'label_heading',
                [
                    'label' => tdf_admin_string('label'),
                    'type' => Controls_Manager::HEADING,
                ]
            );
        }

        $this->add_control(
            'label_color',
            [
                'label' => tdf_admin_string('color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => tdf_admin_string('typography'),
                'selector' => '{{WRAPPER}} ' . $selector,
            ]
        );
    }
}