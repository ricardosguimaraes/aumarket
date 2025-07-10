<?php

namespace Tangibledesign\Framework\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\AlignmentClassControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

abstract class BaseButtonWidget extends BaseGeneralWidget
{
    use AlignmentClassControl;

    protected function addButtonDestinationControl(): void
    {
        $this->add_control(
            'custom_url_switch',
            [
                'label' => tdf_admin_string('custom_url_switch_label'),
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
                    'custom_url_switch!' => '1',
                ],
            ]
        );

        $this->add_control(
            'button_destination_custom',
            [
                'label' => tdf_admin_string('custom_url_label'),
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

    public function getText(): string
    {
        return (string)$this->get_settings_for_display('button_text');
    }

    public function getUrl(): string
    {
        if ($this->get_settings_for_display('custom_url_switch') === '1') {
            return $this->get_settings_for_display('button_destination_custom');
        }

        $destination = $this->get_settings_for_display('button_destination');
        if (is_array($destination)) {
            return '';
        }

        return apply_filters(
            tdf_prefix() . '/button/destination',
            false,
            (string)$destination
        );
    }
}