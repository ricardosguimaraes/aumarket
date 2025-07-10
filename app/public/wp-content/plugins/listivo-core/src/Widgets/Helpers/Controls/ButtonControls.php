<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

trait ButtonControls
{
    use Control;

    protected function addButtonControls(string $defaultType = 'primary_1'): void
    {
        $this->addButtonHeading();

        $this->addButtonTextControl();

        $this->addButtonDestinationControl();

        $this->addButtonTypeControl($defaultType);
    }

    protected function addButtonHeading(): void
    {
        $this->add_control(
            'button_heading',
            [
                'label' => tdf_admin_string('button'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    protected function addButtonDestinationControl(): void
    {
        $this->add_control(
            'custom_url_switch',
            [
                'label' => esc_html__('Use Custom URL', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '0',
                'return_value' => '1',
            ]
        );

        $this->add_control(
            'button_destination',
            [
                'label' => tdf_admin_string('destination'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations'),
                'condition' => [
                    'custom_url_switch' => '0',
                ],
            ]
        );

        $this->add_control(
            'button_destination_custom',
            [
                'label' => esc_html__('Custom URL', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'custom_url_switch' => '1',
                ],
            ]
        );
    }

    protected function addButtonTextControl(): void
    {
        $this->add_control(
            'button_text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXT,
                'default' => tdf_admin_string('button'),
            ]
        );
    }

    public function getButtonText(): string
    {
        return (string)$this->get_settings_for_display('button_text');
    }

    public function getButtonUrl(): string
    {
        if ($this->get_settings_for_display('custom_url_switch') === '1') {
            return $this->get_settings_for_display('button_destination_custom');
        }

        return apply_filters(
            tdf_prefix() . '/button/destination',
            false,
            (string)$this->get_settings_for_display('button_destination')
        );
    }

    private function addButtonTypeControl(string $default = 'primary_1'): void
    {
        $this->add_control(
            'button_type',
            [
                'label' => esc_html__('Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'primary_1' => esc_html__('Primary 1', 'listivo-core'),
                    'primary_2' => esc_html__('Primary 2', 'listivo-core'),
                ],
                'default' => $default,
            ]
        );
    }

    public function getButtonType(): string
    {
        $buttonType = $this->get_settings_for_display('button_type');

        if (empty($buttonType) || !in_array($buttonType, [
                'primary_1',
                'primary_2',
            ], true)) {
            return 'primary_1';
        }

        return $buttonType;
    }

    public function isPrimary1Type(): bool
    {
        return $this->getButtonType() === 'primary_1';
    }

    public function isPrimary2Type(): bool
    {
        return $this->getButtonType() === 'primary_2';
    }
}