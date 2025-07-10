<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TypographyControl;

trait HeadingV2Controls
{
    use Control;
    use TextControls;

    protected function addHeadingControls(): void
    {
        $this->addSmallHeadingControl();

        $this->addHeadingControl();
    }

    protected function addSmallHeadingControl(): void
    {
        $this->add_control(
            'small_heading',
            [
                'label' => esc_html__('Small Heading', 'listivo-core'),
                'type' => Controls_Manager::TEXT
            ]
        );
    }

    protected function addHeadingControl(): void
    {
        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getSmallHeading(): string
    {
        return (string)$this->get_settings_for_display('small_heading');
    }

    /**
     * @return bool
     */
    public function hasSmallHeading(): bool
    {
        return !empty($this->getSmallHeading());
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return (string)$this->get_settings_for_display('heading');
    }

    protected function addHeadingStyleSection(): void
    {
        $this->startStyleControlsSection('style_heading', esc_html__('Heading', 'listivo-core'));

        $this->addSmallHeadingStyleControls();

        $this->addHeadingStyleControls();

        $this->endControlsSection();
    }

    protected function addAlignmentControl(): void
    {
        $this->add_responsive_control(
            'alignment',
            [
                'label' => esc_html__('Alignment', 'listivo-core'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => tdf_admin_string('left'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => tdf_admin_string('center'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => tdf_admin_string('right'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
            ]
        );
    }

    /**
     * @return string
     */
    public function getAlignment(): string
    {
        $alignment = $this->get_settings_for_display('alignment');
        if (empty($alignment)) {
            return 'center';
        }

        return $alignment;
    }

    /**
     * @return string
     */
    public function getTabletAlignment(): string
    {
        $alignment = $this->get_settings_for_display('alignment_tablet');
        if (empty($alignment)) {
            return 'center';
        }

        return $alignment;
    }

    /**
     * @return string
     */
    public function getMobileAlignment(): string
    {
        $alignment = $this->get_settings_for_display('alignment_mobile');
        if (empty($alignment)) {
            return 'center';
        }

        return $alignment;
    }

    protected function addSmallHeadingStyleControls(): void
    {
        $this->add_control(
            'small_heading_style_label',
            [
                'label' => esc_html__('Small heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'small_heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-heading-v2__small-text' => 'color: {{VALUE}} !important;'
                ]
            ]
        );

        $this->add_control(
            'small_heading_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-heading-v2__small-text' => 'background: {{VALUE}} !important;'
                ]
            ]
        );
    }

    protected function addHeadingStyleControls(): void
    {
        $this->add_control(
            'heading_style_label',
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
                    '{{WRAPPER}} .listivo-heading-v2__text' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'heading_accent_color',
            [
                'label' => esc_html__('Accent color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-heading-v2__text span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->addTypographyControl('.listivo-heading-v2__text', 'heading_text');
    }

}