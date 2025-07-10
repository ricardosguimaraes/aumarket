<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class ServicesV5Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'services_v5';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Services V5', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addAddServicesControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addArrowStyleControls();

        $this->addHeadingStyleControls();

        $this->addTextStyleControls();

        $this->endControlsSection();
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
                'label' => esc_html__('title', 'listivo-core'),
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

    private function addArrowStyleControls(): void
    {
        $this->add_control(
            'arrow_color',
            [
                'label' => esc_html__('Arrow color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-service-v5__arrow path' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .listivo-service-v5__decoration rect' => 'stroke: {{VALUE}};',
                    '{{WRAPPER}} .listivo-service-v5__decoration:before' => 'background: linear-gradient(to right, {{VALUE}}, {{VALUE}} 8px, transparent 8px, transparent);background-size: 16px 100%;',
                    '{{WRAPPER}} .listivo-service-v5__decoration:after' => 'background: linear-gradient(to right, {{VALUE}}, {{VALUE}} 8px, transparent 8px, transparent);background-size: 16px 100%;',
                ]
            ]
        );
    }

    private function addHeadingStyleControls(): void
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
                    '{{WRAPPER}} .listivo-service-v5__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'heading_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-service-v5__label',
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
                    '{{WRAPPER}} .listivo-service-v5__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-service-v5__text',
            ]
        );
    }

}