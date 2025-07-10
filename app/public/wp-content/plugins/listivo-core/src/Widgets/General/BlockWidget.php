<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class BlockWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'block';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Block', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

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
                    '{{WRAPPER}} .listivo-block' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-block' => 'height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->addBackgroundImageControl();

        $this->addMaskColorControl();

        $this->addMaskOpacityControl();

        $this->endControlsSection();
    }

    private function addBackgroundImageControl(): void
    {
        $this->add_control(
            'background_image',
            [
                'label' => esc_html__('Background image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    private function addMaskColorControl(): void
    {
        $this->add_control(
            'mask_color',
            [
                'label' => esc_html__('Mask', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-block:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addMaskOpacityControl(): void
    {
        $this->add_control(
            'mask_opacity',
            [
                'label' => esc_html__('Opacity', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-block:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
    }

    /**
     * @return string
     */
    public function getBackgroundImage(): string
    {
        $image = $this->get_settings_for_display('background_image');

        return $image['url'] ?? '';
    }

}