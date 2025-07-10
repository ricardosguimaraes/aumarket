<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class HeadingV2Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;

    public function getKey(): string
    {
        return 'heading_v2';
    }

    public function getName(): string
    {
        return esc_html__('Section Heading V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addSmallHeadingControl();

        $this->addSmallHeadingTagControl();

        $this->addHeadingControl();

        $this->addHeadingTagControl();

        $this->addAlignmentControl();

        $this->endControlsSection();

        $this->addHeadingStyleSection();
    }

    private function addHeadingTagControl(): void
    {
        $this->add_control(
            'heading_tag',
            [
                'label' => esc_html__('Heading Tag', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html__('H1', 'listivo-core'),
                    'h2' => esc_html__('H2', 'listivo-core'),
                    'h3' => esc_html__('H3', 'listivo-core'),
                    'h4' => esc_html__('H4', 'listivo-core'),
                    'h5' => esc_html__('H5', 'listivo-core'),
                    'h6' => esc_html__('H6', 'listivo-core'),
                ],
                'default' => 'h2',
            ]
        );
    }

    public function getHeadingTag(): string
    {
        return (string)$this->get_settings_for_display('heading_tag');
    }

    private function addSmallHeadingTagControl(): void
    {
        $this->add_control(
            'small_heading_tag',
            [
                'label' => esc_html__('Small Heading Tag', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'h1' => esc_html__('H1', 'listivo-core'),
                    'h2' => esc_html__('H2', 'listivo-core'),
                    'h3' => esc_html__('H3', 'listivo-core'),
                    'h4' => esc_html__('H4', 'listivo-core'),
                    'h5' => esc_html__('H5', 'listivo-core'),
                    'h6' => esc_html__('H6', 'listivo-core'),
                ],
                'default' => 'h3',
            ]
        );
    }

    public function getSmallHeadingTag(): string
    {
        return (string)$this->get_settings_for_display('small_heading_tag');
    }
}