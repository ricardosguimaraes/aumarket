<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextAlignControl;

class SocialProfilesV2Widget extends BaseGeneralWidget
{
    use TextAlignControl;

    public function getKey(): string
    {
        return 'social_profiles_v2';
    }

    public function getName(): string
    {
        return esc_html__('Social Profiles V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addTextAlignControl('.' . tdf_prefix() . '-social-icons-wrapper');

        $this->addStyleControl();

        $this->addStyleControls();

        $this->endControlsSection();
    }

    protected function addStyleControl(): void
    {
        $this->add_control(
            'style',
            [
                'label' => esc_html__('Style', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'default' => 'v1',
                'options' => [
                    'v1' => esc_html__('V1', 'listivo-core'),
                    'v2' => esc_html__('V2', 'listivo-core'),
                ]
            ]
        );
    }

    public function getStyle(): string
    {
        $style = $this->get_settings_for_display('style');
        if (empty($style)) {
            return 'v1';
        }

        return (string)$style;
    }

    public function isStyleV2(): bool
    {
        return $this->getStyle() === 'v2';
    }

    private function addStyleControls(): void
    {
        $this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__('Icon hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon:hover i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-social-icon:hover svg path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'border_hover_color',
            [
                'label' => esc_html__('Border hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-social-icon:hover' => 'border-color: {{VALUE}};'
                ]
            ]
        );
    }
}