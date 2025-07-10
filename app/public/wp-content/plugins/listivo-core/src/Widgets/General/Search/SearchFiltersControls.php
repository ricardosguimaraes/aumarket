<?php

namespace Tangibledesign\Listivo\Widgets\General\Search;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait SearchFiltersControls
{
    use Control;

    protected function addShowSearchFiltersControl(): void
    {
        $this->add_control(
            'show_search_filters',
            [
                'label' => esc_html__('Display filter pills', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    /**
     * @return bool
     */
    public function showSearchFilters(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_search_filters'));
    }

    protected function addSearchFilterStyleSection(): void
    {
        $this->startStyleControlsSection('search_filters_section', esc_html__('Search filters', 'listivo-core'));

        $this->add_responsive_control(
            'search_filters_gap',
            [
                'label' => esc_html__('Gap (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-results__filters' => 'gap: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_control(
            'search_filter_heading',
            [
                'label' => esc_html__('Search filter', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'search_filter_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-filter' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'search_filter_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-filter' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'search_filter_border_radius',
            [
                'label' => esc_html__('Border radius', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-filter' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'search_filter_close_heading',
            [
                'label' => esc_html__('Close button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'search_filter_close_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-filter__close path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'search_filter_close_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-search-filter__close' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

}