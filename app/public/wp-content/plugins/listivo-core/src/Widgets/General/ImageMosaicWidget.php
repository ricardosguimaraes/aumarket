<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class ImageMosaicWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'image_mosaic';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Image mosaic', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->add_responsive_control(
            'width',
            [
                'label' => esc_html__('Width', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 2000,
                        'min' => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-image-mosaic' => 'width: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__('Height', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'max' => 2000,
                        'min' => 0,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-image-mosaic' => 'height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_control(
            'image_1',
            [
                'label' => esc_html__('Image 1', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_2',
            [
                'label' => esc_html__('Image 2', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_3',
            [
                'label' => esc_html__('Image 3', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_4',
            [
                'label' => esc_html__('Image 4', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_5',
            [
                'label' => esc_html__('Image 5', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_6',
            [
                'label' => esc_html__('Image 6', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_7',
            [
                'label' => esc_html__('Image 7', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_8',
            [
                'label' => esc_html__('Image 8', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_9',
            [
                'label' => esc_html__('Image 9', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_10',
            [
                'label' => esc_html__('Image 10', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_11',
            [
                'label' => esc_html__('Image 11', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_12',
            [
                'label' => esc_html__('Image 12', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'image_13',
            [
                'label' => esc_html__('Image 13', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->endControlsSection();
    }

    /**
     * @param int $number
     * @return string
     */
    public function getImageUrl(int $number): string
    {
        $image = $this->get_settings_for_display('image_' . $number);

        return $image['url'] ?? '';
    }

}