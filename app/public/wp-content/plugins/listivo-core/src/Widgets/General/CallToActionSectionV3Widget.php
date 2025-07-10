<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ButtonControls;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class CallToActionSectionV3Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use ButtonControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'call_to_action_section_v3';
    }

    public function getName(): string
    {
        return esc_html__('Call To Action Section V3', 'listivo-core');
    }


    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addBackgroundImageControl();

        $this->addBackgroundColorControl();

        $this->addBackgroundOpacityControl();

        $this->addHeadingControls();

        $this->addButtonControls();

        $this->addImagesControls();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addSmallHeadingStyleControls();

        $this->addHeadingStyleControls();

        $this->endControlsSection();
    }

    private function addBackgroundImageControl(): void
    {
        $this->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
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

    private function addImagesControls(): void
    {
        $this->add_control(
            'images',
            [
                'label' => esc_html__('Images', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
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
    }

    /**
     * @return string
     */
    public function getImage1(): string
    {
        $image = $this->get_settings_for_display('image_1');
        return $image['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getImage2(): string
    {
        $image = $this->get_settings_for_display('image_2');
        return $image['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getImage3(): string
    {
        $image = $this->get_settings_for_display('image_3');
        return $image['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getImage4(): string
    {
        $image = $this->get_settings_for_display('image_4');
        return $image['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getImage5(): string
    {
        $image = $this->get_settings_for_display('image_5');
        return $image['url'] ?? '';
    }

    /**
     * @return string
     */
    public function getImage6(): string
    {
        $image = $this->get_settings_for_display('image_6');
        return $image['url'] ?? '';
    }

    private function addBackgroundColorControl(): void
    {
        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-call-to-action-section-v3:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addBackgroundOpacityControl(): void
    {
        $this->add_control(
            'background_mask_opacity',
            [
                'label' => esc_html__('Mask opacity', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-call-to-action-section-v3:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
    }

}