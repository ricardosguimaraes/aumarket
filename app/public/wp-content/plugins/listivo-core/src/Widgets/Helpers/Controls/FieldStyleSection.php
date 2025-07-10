<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait FieldStyleSection
{
    use Control;

    /**
     * @param string $selector
     * @return void
     */
    protected function addFieldStyleSection(string $selector = ''): void
    {
        $this->startStyleControlsSection('form_field_style', esc_html__('Form field', 'listivo-core'));

        $this->add_control(
            'form_input_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2 input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2 input:placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__option' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input input' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input__option' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2' => 'background: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2 input' => 'background: {{VALUE}} !important;',
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2__clear' => 'background: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2' => 'background: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__arrow' => 'background: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__clear' => 'background: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input' => 'background: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input input' => 'background: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input__placeholder' => 'background: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input__clear' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_dropdown_bg',
            [
                'label' => esc_html__('Dropdown background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__dropdown' => 'background: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input__dropdown' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_border_heading',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'form_input_border_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2 input' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2__clear path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__arrow path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__clear path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input__clear path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_border_active_color',
            [
                'label' => esc_html__('Active color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2--active' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-input-v2--active input' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2--active' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input--active' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_icon_heading',
            [
                'label' => esc_html__('Field icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'form_input_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-icon-v2 path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-icon-v2' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-icon-v2' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_select_option_heading',
            [
                'label' => esc_html__('Dropdown option', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'form_input_match_color',
            [
                'label' => esc_html__('Match color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__option--highlight-text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input__option--highlight-text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_highlight_color',
            [
                'label' => esc_html__('Highlight color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__option:hover' => 'color:: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-autocomplete-input__option:hover' => 'color:: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_checkbox_heading',
            [
                'label' => esc_html__('Dropdown option checkbox', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'form_input_checkbox_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__checkbox path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-checkbox path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_checkbox_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__checkbox' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-checkbox' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_checkbox_active_bg',
            [
                'label' => esc_html__('Active background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__option--active .listivo-select-v2__checkbox' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-checkbox--checked' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_checkbox_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__checkbox' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} ' . $selector . ' .listivo-checkbox' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_number_heading',
            [
                'label' => esc_html__('Number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'form_input_number_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'form_input_number_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} ' . $selector . ' .listivo-select-v2__count' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    protected function renderCustomFieldStyles(): void
    {
        $settings = $this->get_settings_for_display();

        $variables = [
            'form_input_dropdown_bg' => [
                'attributes' => ['background', 'border-color'],
                'selectors' => ['.pac-container'],
            ],
            'form_input_color' => [
                'attributes' => ['color'],
                'selectors' => ['.pac-item', '.pac-item-query']
            ],
            'form_input_match_color' => [
                'attributes' => ['color'],
                'selectors' => ['.pac-matched'],
            ],
            'form_input_highlight_color' => [
                'attributes' => ['color'],
                'selectors' => ['.pac-item:hover .pac-item-query'],
            ]
        ];

        foreach ($variables as $var => $attributeData) {
            if (!empty($settings['__globals__'][$var])) {
                $value = 'var(--e-global-color-' . str_replace('globals/colors?id=', '', $settings['__globals__'][$var] . ')');
            } elseif (isset($settings[$var])) {
                $value = $settings[$var];
            } else {
                continue;
            }

            add_action('wp_footer', function () use ($attributeData, $value) {
                ?>
                <style>
                    <?php foreach ($attributeData['attributes'] as $attribute) { ?>
                    <?php foreach ($attributeData['selectors'] as $selector) { ?>
                    <?php echo esc_html($selector . ' {'.$attribute.': ' . $value) . ' !important;}'; ?>
                    <?php } ?>
                    <?php } ?>
                </style>
                <?php
            });
        }
    }

}