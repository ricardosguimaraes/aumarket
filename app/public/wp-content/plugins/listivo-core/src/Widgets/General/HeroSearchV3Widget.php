<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TypographyControl;

class HeroSearchV3Widget extends SearchFormWidget
{
    use TypographyControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'hero_search_v3';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hero Search V3', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->addContentControls();

        $this->addStyleControls();
    }

    private function addContentControls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControl();

        $this->addSearchFormLabelControl();

        $this->addButtonLabelControl();

        $this->addFieldsControl();

        $this->endControlsSection();
    }

    public function addHeadingControl(): void
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
    public function getHeading(): string
    {
        return (string)$this->get_settings_for_display('heading');
    }

    private function addStyleControls(): void
    {
        $this->addHeadingStyleSection();

        $this->addSearchButtonStyleSection();
    }

    private function addSearchButtonStyleSection(): void
    {
        $this->startStyleControlsSection(
            'lst_search_button',
            esc_html__('Search Button', 'listivo-core')
        );

        $this->start_controls_tabs('button_colors_tabs');

        $this->start_controls_tab(
            'button_colors_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search__search-button button' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search__search-button button' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-primary-button--loading:after' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'button_colors_hover_tab',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search__search-button button:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'button_bg_color_hover',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search__search-button button:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }

    private function addHeadingStyleSection(): void
    {
        $this->startStyleControlsSection(
            'lst_heading',
            esc_html__('Heading', 'listivo-core')
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'heading_typography',
                'selector' => '{{WRAPPER}} .listivo-hero-search-v3__heading',
            ]
        );

        $this->add_control(
            'heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-hero-search-v3__heading' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addSearchFormLabelControl(): void
    {
        $this->add_control(
            'search_form_label',
            [
                'label' => esc_html__('Search Form Label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    /**
     * @return string
     */
    public function getSearchFormLabel(): string
    {
        return (string)$this->get_settings_for_display('search_form_label');
    }

    private function addButtonLabelControl(): void
    {
        $this->add_control(
            'button_label',
            [
                'label' => esc_html__('Button Label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('search'),
            ]
        );
    }

    /**
     * @return string
     */
    public function getButtonLabel(): string
    {
        $label = (string)$this->get_settings_for_display('button_label');
        if (empty($label)) {
            return tdf_string('search');
        }

        return $label;
    }

}