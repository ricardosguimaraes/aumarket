<?php

namespace Tangibledesign\Listivo\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Group_Control_Typography;

class PaginationTab extends Tab_Base
{
    /**
     * @return string
     */
    public function get_id(): string
    {
        return 'listivo-pagination';
    }

    /**
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('Pagination', 'listivo-core');
    }

    /**
     * @return string
     */
    public function get_group(): string
    {
        return 'theme-style';
    }

    /**
     * @return string
     */
    public function get_icon(): string
    {
        return 'fas fa-paint-brush';
    }

    protected function register_tab_controls(): void
    {
        $this->start_controls_section(
            'listivo_pagination',
            [
                'label' => esc_html__('Listivo Pagination', 'listivo-core'),
                'tab' => $this->get_id(),
            ]
        );

        $this->addTextControls();

        $this->addItemsControls();

        $this->end_controls_section();
    }

    private function addTextControls(): void
    {
        $this->add_control(
            'pagination_results_text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'pagination_results_text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__info' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'pagination_results_text_typography',
                'selector' => '{{WRAPPER}} .listivo-pagination__info',
            ]
        );

        $this->add_control(
            'pagination_bold_results_text_heading',
            [
                'label' => esc_html__('Numbers', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'pagination_bold_results_text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__info span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'pagination_bold_results_text_typography',
                'selector' => '{{WRAPPER}} .listivo-pagination__info span',
            ]
        );
    }

    private function addItemsControls(): void
    {
        $this->add_control(
            'pagination_item_heading',
            [
                'label' => esc_html__('Item', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'pagination_item_border_radius',
            [
                'label' => esc_html__('Border radius (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item' => 'border-radius: {{VALUE}}px;'
                ]
            ]
        );

        $this->add_control(
            'pagination_item_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item:not(.listivo-pagination__item--active)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item:not(.listivo-pagination__item--active) path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'pagination_item_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item:not(.listivo-pagination__item--active):hover' => 'color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item:not(.listivo-pagination__item--active):hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'pagination_item_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item:not(.listivo-pagination__item--active)' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'pagination_item_hover_background',
            [
                'label' => esc_html__('Hover background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item:not(.listivo-pagination__item--active):hover' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'pagination_active_item_heading',
            [
                'label' => esc_html__('Active item', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'pagination_item_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--active' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--active path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--active:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--active:hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'pagination_item_active_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--active' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--active:hover' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'pagination_disabled_item_heading',
            [
                'label' => esc_html__('Disabled item', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'pagination_item_disabled_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--disabled' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--disabled path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--disabled:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--disabled:hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'pagination_item_disabled_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--disabled' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--disabled:hover' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'pagination_separator_item_heading',
            [
                'label' => esc_html__('Separator item', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'pagination_item_separator_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--separator' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--separator path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--separator:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--separator:hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'pagination_item_separator_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--separator' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .listivo-pagination__item.listivo-pagination__item--separator:hover' => 'background: {{VALUE}};',
                ]
            ]
        );
    }

}