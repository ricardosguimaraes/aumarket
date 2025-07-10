<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class ServicesV8Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'services_v8';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Services V8', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addAddServicesControl();

        $this->endControlsSection();

        $this->addStyleSection();
    }

    private function addAddServicesControl(): void
    {
        $services = new Repeater();

        $services->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $services->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );

        $services->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'services',
            [
                'label' => esc_html__('Services', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $services->get_controls(),
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getServices(): Collection
    {
        $services = $this->get_settings_for_display('services');
        if (empty($services) || !is_array($services)) {
            return tdf_collect();
        }

        return tdf_collect($services);
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->addIconControls();

        $this->addLabelStyleControls();

        $this->addTextStyleControls();

        $this->endControlsSection();
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
            'icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-service-v8__icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_border',
            [
                'label' => esc_html__('Border width (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-service-v8__icon' => 'border: {{VALUE}}px solid transparent;',
                ]
            ]
        );

        $this->add_control(
            'icon_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-service-v8__icon' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->addIconShadowControl();
    }

    private function addLabelStyleControls(): void
    {
        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-service-v8__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .listivo-service-v8__label',
            ]
        );
    }

    private function addTextStyleControls(): void
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
                    '{{WRAPPER}} .listivo-service-v8__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .listivo-service-v8__text',
            ]
        );
    }

    private function addIconShadowControl(): void
    {
        $this->add_control(
            'icon_shadow',
            [
                'label' => esc_html__('Shadow', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    /**
     * @return bool
     */
    public function hasIconShadow(): bool
    {
        return !empty((int)$this->get_settings_for_display('icon_shadow'));
    }

}