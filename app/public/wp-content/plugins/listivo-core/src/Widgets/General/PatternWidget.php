<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class PatternWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'pattern';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Pattern', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'pattern',
            [
                'label' => esc_html__('Pattern', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'v1' => esc_html__('V1', 'listivo-core'),
                    'v2' => esc_html__('V2', 'listivo-core'),
                    'v3' => esc_html__('V3', 'listivo-core'),
                    'v4' => esc_html__('V4', 'listivo-core'),
                ],
                'default' => 'v1',
            ]
        );

        $this->addPatternV1ColorsControl();

        $this->addPatternV4ColorControls();

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    public function getPattern(): string
    {
        $pattern = $this->get_settings_for_display('pattern');
        if (empty($pattern)) {
            return 'v1';
        }

        return $pattern;
    }

    /**
     * @return bool
     */
    public function isPatternV1(): bool
    {
        return $this->getPattern() === 'v1';
    }

    /**
     * @return bool
     */
    public function isPatternV2(): bool
    {
        return $this->getPattern() === 'v2';
    }

    /**
     * @return bool
     */
    public function isPatternV3(): bool
    {
        return $this->getPattern() === 'v3';
    }

    /**
     * @return bool
     */
    public function isPatternV4(): bool
    {
        return $this->getPattern() === 'v4';
    }

    private function addPatternV1ColorsControl(): void
    {
        $this->add_control(
            'color_v1_1',
            [
                'label' => esc_html__('Color 1', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-fill-primary-1' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'pattern' => ['v1', 'v2', 'v3'],
                ]
            ]
        );

        $this->add_control(
            'color_v1_2',
            [
                'label' => esc_html__('Color 2', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-fill-primary-2' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'pattern' => ['v1', 'v2', 'v3'],
                ]
            ]
        );

        $this->add_control(
            'color_v1_3',
            [
                'label' => esc_html__('Color 3', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-fill-color-4' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'pattern' => ['v1', 'v2', 'v3'],
                ]
            ]
        );

        $this->add_control(
            'color_v1_4',
            [
                'label' => esc_html__('Color 4', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-stroke-color-5' => 'stroke: {{VALUE}};',
                ],
                'condition' => [
                    'pattern' => ['v1', 'v2', 'v3'],
                ]
            ]
        );
    }

    private function addPatternV4ColorControls(): void
    {
        $this->add_control(
            'color_v4_1',
            [
                'label' => esc_html__('Color 1', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-fill-primary-1' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'pattern' => 'v4',
                ]
            ]
        );

        $this->add_control(
            'color_v4_2',
            [
                'label' => esc_html__('Color 2', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-fill-primary-2' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'pattern' => 'v4',
                ]
            ]
        );

        $this->add_control(
            'color_v4_3',
            [
                'label' => esc_html__('Color 3', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pattern__fill-v4' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'color_v4_4',
            [
                'label' => esc_html__('Color 4', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-fill-color-4' => 'fill: {{VALUE}};',
                ]
            ]
        );
    }

}