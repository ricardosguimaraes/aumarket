<?php

namespace Tangibledesign\Listivo\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;

class QuickViewTab extends Tab_Base
{
    /**
     * @return string
     */
    public function get_id(): string
    {
        return 'listivo-quick-view';
    }

    /**
     * @return string
     */
    public function get_title(): string
    {
        return esc_html__('Quick View', 'listivo-core');
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
            'listivo_quick_view',
            [
                'label' => esc_html__('Listivo Quick View', 'listivo-core'),
                'tab' => $this->get_id(),
            ]
        );

        $this->addCategoryFieldsControl();

        $this->addAttributeFieldsControl();

        $this->addButtonTypeControl();

        $this->addMetaControls();

        $this->addNameControls();

        $this->addFirstCategoryControls();

        $this->addCategoryControls();

        $this->addAddressControls();

        $this->addAttributeControls();

        $this->addPrimaryValueControls();

        $this->end_controls_section();
    }

    private function addCategoryFieldsControl(): void
    {
        $options = [];
        foreach (tdf_simple_text_value_fields() as $field) {
            $options[tdf_prefix() . '_' . $field->getId()] = $field->getName();
        }

        $fields = new Repeater();
        $fields->add_control(
            'field',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->add_control(
            'listivo_quick_preview_categories',
            [
                'label' => esc_html__('Category fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    private function addAttributeFieldsControl(): void
    {
        $options = [];
        foreach (tdf_simple_text_value_fields() as $field) {
            $options[tdf_prefix() . '_' . $field->getId()] = $field->getName();
        }

        $fields = new Repeater();

        $fields->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $fields->add_control(
            'field',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->add_control(
            'listivo_quick_preview_attributes',
            [
                'label' => esc_html__('Attributes fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    private function addButtonTypeControl(): void
    {
        $this->add_control(
            'listivo_quick_view_button_type',
            [
                'label' => esc_html__('Button type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'primary_1' => esc_html__('Primary 1', 'listivo-core'),
                    'primary_2' => esc_html__('Primary 2', 'listivo-core'),
                ],
                'default' => 'primary_1',
            ]
        );
    }

    private function addAttributeControls(): void
    {
        $this->add_control(
            'listivo_quick_view_attributes_heading',
            [
                'label' => esc_html__('Attributes', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_quick_view_attributes_icon_color',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__attribute-icon path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-quick-view__attribute-icon i' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_quick_view_attributes_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__attribute' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_quick_view_attributes_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__attribute' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_quick_view_attributes_typo',
                'selector' => '{{WRAPPER}} .listivo-quick-view__attribute',
            ]
        );
    }

    private function addPrimaryValueControls(): void
    {
        $this->add_control(
            'listivo_quick_view_primary_value_heading',
            [
                'label' => esc_html__('Primary value', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_quick_view_primary_value_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__price' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_quick_view_primary_value_typo',
                'selector' => '{{WRAPPER}} .listivo-quick-view__price',
            ]
        );
    }

    private function addAddressControls(): void
    {
        $this->add_control(
            'listivo_quick_view_address_heading',
            [
                'label' => esc_html__('Address', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_quick_view_address_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__address' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_quick_view_address_typo',
                'selector' => '{{WRAPPER}} .listivo-quick-view__address',
            ]
        );

        $this->add_control(
            'listivo_quick_view_address_icon_color',
            [
                'label' => esc_html__('Icon color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__address-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_quick_view_address_icon_bg',
            [
                'label' => esc_html__('Icon background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__address-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addFirstCategoryControls(): void
    {
        $this->add_control(
            'listivo_quick_view_first_category_heading',
            [
                'label' => esc_html__('First category', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_quick_view_first_category_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__category:first-child' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_quick_view_first_category_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__category:first-child' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_quick_view_first_category_typo',
                'selector' => '{{WRAPPER}} .listivo-quick-view__category:first-child',
            ]
        );
    }

    private function addCategoryControls(): void
    {
        $this->add_control(
            'listivo_quick_view_category_heading',
            [
                'label' => esc_html__('Category', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_quick_view_category_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__category' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_quick_view_category_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__category' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_quick_view_category_typo',
                'selector' => '{{WRAPPER}} .listivo-quick-view__category',
            ]
        );
    }

    private function addNameControls(): void
    {
        $this->add_control(
            'listivo_quick_view_name_heading',
            [
                'label' => esc_html__('Ad name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_quick_view_name_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__heading' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_quick_view_name_typo',
                'selector' => '{{WRAPPER}} .listivo-quick-view__heading',
            ]
        );
    }

    private function addMetaControls(): void
    {
        $this->add_control(
            'listivo_quick_view_meta_heading',
            [
                'label' => esc_html__('Meta data', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_quick_view_meta_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__meta' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'listivo_quick_view_meta_typo',
                'selector' => '{{WRAPPER}} .listivo-quick-view__meta',
            ]
        );

        $this->add_control(
            'listivo_quick_view_meta_icon_color',
            [
                'label' => esc_html__('Icon color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__meta-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_quick_view_meta_icon_bg',
            [
                'label' => esc_html__('Icon background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-quick-view__meta-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

}