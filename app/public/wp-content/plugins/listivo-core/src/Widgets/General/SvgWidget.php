<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class SvgWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'svg';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('SVG', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'svg',
            [
                'label' => esc_html__('SVG', 'listivo-core'),
                'type' => Controls_Manager::CODE,
            ]
        );

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->add_control(
            'fill',
            [
                'label' => esc_html__('Fill', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'stroke',
            [
                'label' => esc_html__('Stroke', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} path' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} svg' => 'width: {{SIZE}}{{UNIT}}; height: auto;',
                ]
            ]
        );

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    public function getSvg(): string
    {
        return (string)$this->get_settings_for_display('svg');
    }

}