<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\ImageControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextareaControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class ContentV7Widget extends BaseGeneralWidget
{
    use TextareaControl;
    use ImageControl;

    public function getKey(): string
    {
        return 'content_v7';
    }

    public function getName(): string
    {
        return esc_html__('Content section V7', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControl();

        $this->addTextControl();

        $this->addImageControl();

        $this->addButtonHeading();

        $this->addButtonTextControl();

        $this->addButtonDestinationControl();

        $this->addSecondButtonHeading();

        $this->addSecondButtonTextControl();

        $this->addSecondButtonDestinationControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addHeadingTypographyControl();

        $this->endControlsSection();
    }

    private function addHeadingControl(): void
    {
        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    public function getHeading(): string
    {
        return (string)$this->get_settings_for_display('heading');
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

    protected function addSecondButtonHeading(): void
    {
        $this->add_control(
            'button_2_heading',
            [
                'label' => esc_html__('Second button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    protected function addSecondButtonDestinationControl(): void
    {
        $this->add_control(
            'custom_url_switch_2',
            [
                'label' => esc_html__('Use Custom URL', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'default' => '0',
                'return_value' => '1',
            ]
        );

        $this->add_control(
            'button_2_destination',
            [
                'label' => tdf_admin_string('destination'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations'),
                'condition' => [
                    'custom_url_switch_2' => '0',
                ],
            ]
        );

        $this->add_control(
            'button_2_destination_custom',
            [
                'label' => esc_html__('Custom URL', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'condition' => [
                    'custom_url_switch_2' => '1',
                ],
            ]
        );
    }

    protected function addSecondButtonTextControl(): void
    {
        $this->add_control(
            'button_2_text',
            [
                'label' => tdf_admin_string('text'),
                'type' => Controls_Manager::TEXT,
                'default' => tdf_admin_string('button'),
            ]
        );
    }

    public function getSecondButtonText(): string
    {
        return (string)$this->get_settings_for_display('button_2_text');
    }

    public function getSecondButtonUrl(): string
    {
        if ($this->get_settings_for_display('custom_url_switch_2') === '1') {
            return $this->get_settings_for_display('button_2_destination_custom');
        }

        return apply_filters(
            tdf_prefix() . '/button/destination',
            false,
            (string)$this->get_settings_for_display('button_2_destination')
        );
    }

    private function addHeadingTypographyControl(): void
    {
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typo',
                'label' => esc_html__('Heading', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-content-v7__heading',
            ]
        );
    }
}