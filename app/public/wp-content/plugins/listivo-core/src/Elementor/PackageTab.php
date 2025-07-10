<?php

namespace Tangibledesign\Listivo\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Group_Control_Typography;

class PackageTab extends Tab_Base
{
    /**
     * @return string
     */
    public function get_id(): string
    {
        return 'listivo-package';
    }

    /**
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('Package', 'listivo-core');
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
            'listivo_package',
            [
                'label' => esc_html__('Listivo Package', 'listivo-core'),
                'tab' => $this->get_id(),
            ]
        );

        $this->add_control(
            'listivo_regular_package_top_heading',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_regular_package_top_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__head' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_regular_package_top_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__head' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_regular_package_top_typo',
                'selector' => '{{WRAPPER}} .listivo-panel-package-v2__head',
            ]
        );

        $this->add_control(
            'listivo_regular_package_label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_regular_package_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_regular_package_label_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__label' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_regular_package_label_typo',
                'selector' => '{{WRAPPER}} .listivo-panel-package-v2__label',
            ]
        );

        $this->add_control(
            'listivo_regular_package_price_heading',
            [
                'label' => esc_html__('Price', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_regular_package_price_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__main-value' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_regular_package_price_typo',
                'selector' => '{{WRAPPER}} .listivo-panel-package-v2__main-value',
            ]
        );

        $this->add_control(
            'listivo_regular_package_button_heading',
            [
                'label' => esc_html__('Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_regular_package_button_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__button .listivo-simple-button' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_regular_package_button_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__button .listivo-simple-button' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_regular_package_text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_regular_package_text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__description' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_regular_package_text_typo',
                'selector' => '{{WRAPPER}} .listivo-panel-package-v2__description',
            ]
        );

        $this->add_control(
            'listivo_regular_package_icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_regular_package_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__attribute-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_regular_package_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__attribute-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_regular_package_attribute_heading',
            [
                'label' => esc_html__('Attribute', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_regular_package_attribute_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2__attribute-value' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_regular_package_attribute_typo',
                'selector' => '{{WRAPPER}} .listivo-panel-package-v2__attribute-value',
            ]
        );

        $this->add_control(
            'listivo_featured_package_heading',
            [
                'label' => esc_html__('Featured package', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_package_border_color',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2--featured:not(.listivo-panel-package-v2--active) .listivo-panel-package-v2__body' => 'border-left-color: {{VALUE}}; border-right-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-panel-package-v2--featured:not(.listivo-panel-package-v2--active).listivo-panel-package-v2--no-bottom .listivo-panel-package-v2__body' => 'border-bottom-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_package_name_heading',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_featured_package_name_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2--featured:not(.listivo-panel-package-v2--active) .listivo-panel-package-v2__head' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_control(
            'listivo_featured_package_name_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-package-v2--featured:not(.listivo-panel-package-v2--active) .listivo-panel-package-v2__head' => 'background-color: {{VALUE}}',
                ]
            ]
        );

        $this->end_controls_section();
    }

}