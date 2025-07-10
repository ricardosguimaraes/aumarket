<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class InfoWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'info';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Info Section', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addImageControl();

        $this->addTitleControl();

        $this->addTextControl();

        $this->addAttributesControl();

        $this->addButtonControls();

        $this->endControlsSection();
    }

    private function addImageControl(): void
    {
        $this->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        $data = $this->get_settings_for_display('image');

        return $data['url'] ?? '';
    }

    private function addTitleControl(): void
    {
        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return (string)$this->get_settings_for_display('title');
    }

    private function addTextControl(): void
    {
        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::WYSIWYG,
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

    private function addAttributesControl(): void
    {
        $attributes = new Repeater();

        $attributes->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $attributes->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'attributes',
            [
                'label' => esc_html__('Attributes', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $attributes->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        $attributes = $this->get_settings_for_display('attributes');
        if (empty($attributes) || !is_array($attributes)) {
            return [];
        }

        return $attributes;
    }

    private function addButtonControls(): void
    {
        $this->add_control(
            'button_heading',
            [
                'label' => esc_html__('Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $this->add_control(
            'button_destination',
            [
                'label' => esc_html__('Destination', 'listivo-core'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url(tdf_prefix() . '/button/destinations')
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => tdf_admin_string('icon'),
                'type' => Controls_Manager::ICONS,
            ]
        );
    }

    /**
     * @return string
     */
    public function getButtonText(): string
    {
        return (string)$this->get_settings_for_display('button_text');
    }

    /**
     * @return string
     */
    public function getButtonUrl(): string
    {
        return apply_filters(
            tdf_prefix() . '/button/destination',
            false,
            (string)$this->get_settings_for_display('button_destination')
        );
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        $icon = $this->get_settings_for_display('icon');

        if ($icon['library'] === 'svg') {
            return $icon['value']['url'] ?? '';
        }

        return $icon['value'] ?? '';
    }

    /**
     * @return string
     */
    public function getIconType(): string
    {
        $icon = $this->get_settings_for_display('icon');
        return $icon['library'];
    }

    /**
     * @return bool
     */
    public function isSvgIcon(): bool
    {
        return $this->getIconType() === 'svg';
    }

}