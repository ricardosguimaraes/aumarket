<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class IconBoxWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'icon_box';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Icon box', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addIconControl();

        $this->addHeadingControl();

        $this->addTextControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addBackgroundColorControl();

        $this->addIconControls();

        $this->addHeadingControls();

        $this->addTextControls();

        $this->endControlsSection();
    }

    private function addIconControl(): void
    {
        $this->add_control(
            'icon_type',
            [
                'label' => esc_html__('Icon type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'icon' => esc_html__('Icon', 'listivo-core'),
                    'image' => esc_html__('Image', 'listivo-core'),
                ],
                'default' => 'icon',
            ]
        );

        $this->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
                'condition' => [
                    'icon_type' => 'icon',
                ]
            ]
        );

        $this->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'icon_type' => 'image',
                ]
            ]
        );
    }

    /**
     * @return bool
     */
    public function isTypeIcon(): bool
    {
        return $this->get_settings_for_display('icon_type') === 'icon';
    }

    /**
     * @return array|false
     */
    public function getIcon()
    {
        $icon = $this->get_settings_for_display('icon');
        if (!is_array($icon)) {
            return false;
        }

        return $icon;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        $image = $this->get_settings_for_display('image');

        return $image['url'] ?? '';
    }

    private function addHeadingControl(): void
    {
        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return (string)$this->get_settings_for_display('heading');
    }

    private function addTextControl(): void
    {
        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->get_settings_for_display('text');
    }

    private function addBackgroundColorControl(): void
    {
        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-icon-box' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addIconControls(): void
    {
        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-icon-box__icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-icon-box__icon svg' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-icon-box__icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addHeadingControls(): void
    {
        $this->add_control(
            'heading_heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-icon-box__heading' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .listivo-icon-box__heading',
            ]
        );
    }

    private function addTextControls(): void
    {
        $this->add_control(
            'text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-icon-box__text' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .listivo-icon-box__text',
            ]
        );
    }

}