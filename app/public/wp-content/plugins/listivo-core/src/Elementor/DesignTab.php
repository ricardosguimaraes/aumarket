<?php

namespace Tangibledesign\Listivo\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Group_Control_Typography;

class DesignTab extends Tab_Base
{

    public function get_id(): string
    {
        return 'listivo-design';
    }

    public function get_title(): string
    {
        return esc_html__('Design', 'listivo-core');
    }

    public function get_group(): string
    {
        return 'theme-style';
    }

    public function get_icon(): string
    {
        return 'fas fa-paint-brush';
    }

    protected function register_tab_controls(): void
    {
        $this->start_controls_section(
            'listivo_design',
            [
                'label' => esc_html__('Listivo Design', 'listivo-core'),
                'tab' => $this->get_id(),
            ]
        );

        $this->add_control(
            'design_link_color',
            [
                'label' => esc_html__('Link Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-text-editor a:not(.listivo-button)' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-widget-text-editor a:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-single-post__content a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-single-post__content a:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v1__text a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v1__text a:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v2__text a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v2__text a:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v3__text a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v3__text a:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v4__text a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v4__text a:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v5__text a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v5__text a:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v6__text a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-content-v6__text a:before' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-listing-section__text a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-listing-section__text a:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'design_border_radius',
            [
                'label' => esc_html__('Border Radius', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}}' => '--e-global-lborder-radius: {{VALUE}}px;',
                    '{{WRAPPER}} .listivo-input-v2__clear' => 'border-radius: {{VALUE}}px;',
                    '{{WRAPPER}} .listivo-select-v2__clear' => 'border-radius: {{VALUE}}px;',
                    '{{WRAPPER}} .listivo-select-v2__arrow' => 'border-radius: {{VALUE}}px;',
                    '{{WRAPPER}} .listivo-autocomplete-input__clear' => 'border-radius: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'design_large_border_radius',
            [
                'label' => esc_html__('Larger Border Radius', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}}' => '--e-global-lborder-radius-large: {{VALUE}}px;',
                ],
            ]
        );

        $this->add_control(
            'design_shadow_heading',
            [
                'label' => esc_html__('Shadow', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'design_shadow',
            [
                'label' => esc_html__('Shadow', 'listivo-core'),
                'type' => Controls_Manager::BOX_SHADOW,
                'selectors' => [
                    '{{WRAPPER}}' => '--e-global-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}}; --e-global-shadow-filter: drop-shadow({{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{COLOR}});',
                ]
            ]
        );

        $this->addFormInputIconControls();

        $this->addSmallHeadingControls();

        $this->addHeadingControls();

        $this->addButtonControls();

        $this->addNavigationArrowControls();

        $this->addTabsControls();

        $this->addLoginRegisterControls();

        $this->addSelectControls();

        $this->addImagePlaceholderControls();

        $this->end_controls_section();
    }

    private function addFormInputIconControls(): void
    {
        $this->add_control(
            'design_form_input_icon_label',
            [
                'label' => esc_html__('Form input icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'design_form_input_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-icon-v2 svg path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-icon-v2' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'design_form_input_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-icon-v2' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'design_form_input_error_color',
            [
                'label' => esc_html__('Error Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-input-v2--error input' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-select-v2--error' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-has-error .listivo-panel-form-label__text' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-has-error .listivo-panel-form-label__text span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-field-error' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-field-error__icon path:last-child' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'design_form_input_error_text_color',
            [
                'label' => esc_html__('Error Text Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-field-error' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-field-error__icon path:first-child' => 'fill: {{VALUE}};',
                ]
            ]
        );
    }

    private function addHeadingControls(): void
    {
        $this->add_control(
            'design_heading_label',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'design_heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-heading-v2__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'design_heading_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $this->getWrapper() . ' .listivo-heading-v2__text',
            ]
        );
    }

    private function addSmallHeadingControls(): void
    {
        $this->add_control(
            'design_small_heading_label',
            [
                'label' => esc_html__('Small heading', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'design_small_heading_border_radius',
            [
                'label' => esc_html__('Border radius (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-heading-v2__small-text' => 'border-radius: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'design_small_heading_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-heading-v2__small-text' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'design_small_heading_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-heading-v2__small-text' => 'background: {{VALUE}};'
                ]
            ]
        );
    }

    private function addButtonControls(): void
    {
        $this->add_control(
            'buttons_heading',
            [
                'label' => esc_html__('Buttons', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'buttons_border_radius',
            [
                'label' => esc_html__('Border radius (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-button--primary-1' => 'border-radius: {{VALUE}}px;',
                    $this->getWrapper() . ' .listivo-button-primary-1-selector' => 'border-radius: {{VALUE}}px;',
                    $this->getWrapper() . ' .listivo-button--primary-2' => 'border-radius: {{VALUE}}px;',
                    $this->getWrapper() . ' .listivo-button-primary-2-selector' => 'border-radius: {{VALUE}}px;',
                    $this->getWrapper() . ' .listivo-button--regular' => 'border-radius: {{VALUE}}px;',
                    $this->getWrapper() . ' .listivo-button-border-radius-selector' => 'border-radius: {{VALUE}}px;'
                ]
            ]
        );

        $this->add_control(
            'button_regular_heading',
            [
                'label' => esc_html__('Button regular', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'button_regular_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-button--regular' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button--regular path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_regular_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-button--regular:hover' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button--regular:hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_regular_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-button--regular' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_regular_hover_background',
            [
                'label' => esc_html__('Hover background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-button--regular:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_primary_1_heading',
            [
                'label' => esc_html__('Button primary 1', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'button_primary_1_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-button--primary-1' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button--primary-1 path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button--primary-1 rect' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-selector' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-selector path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-selector rect' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-colors-selector' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-colors-selector path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-colors-selector rect' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-colors-with-stroke-selector path' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-colors-with-stroke-selector rect' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_primary_1_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-button--primary-1' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-selector' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-1-colors-selector' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_primary_2_heading',
            [
                'label' => esc_html__('Button primary 2', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'button_primary_2_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-button--primary-2' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button--primary-2 path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button--primary-2 rect' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-selector' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-selector path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-selector rect' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-colors-selector' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-colors-selector path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-colors-selector rect' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-colors-with-stroke-selector path' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-colors-with-stroke-selector rect' => 'fill: {{VALUE}}; stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_primary_2_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-button--primary-2' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-selector' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-button-primary-2-colors-selector' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addNavigationArrowControls(): void
    {
        $this->add_control(
            'nav_arrow_heading',
            [
                'label' => esc_html__('Navigation arrow', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'nav_arrow_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-box-arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'nav_arrow_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-box-arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'nav_arrow_border_radius',
            [
                'label' => esc_html__('Border radius (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-box-arrow' => 'border-radius: {{VALUE}}px;',
                ]
            ]
        );
    }

    private function addTabsControls(): void
    {
        $this->add_control(
            'tabs_heading',
            [
                'label' => esc_html__('Tabs', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'tabs_border_radius',
            [
                'label' => esc_html__('Border radius (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-tab-v2' => 'border-radius: {{VALUE}}px;',
                ]
            ]
        );
    }

    private function addLoginRegisterControls(): void
    {
        $this->add_control(
            'login_heading',
            [
                'label' => esc_html__('Login and register', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'login_button_type',
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

        $this->add_control(
            'login_link_color',
            [
                'label' => esc_html__('Link color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-login-form__lost-password' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-login-form__lost-password:before' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-login-form__policy a' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-login-form__policy a:before' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-login-form__marketing-consent-text a' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-login-form__marketing-consent-text a:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'login_input_bg',
            [
                'label' => esc_html__('Input background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-login-form .listivo-input-v2 input' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'login_input_border_color',
            [
                'label' => esc_html__('Input border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-login-form .listivo-input-v2' => 'border-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addSelectControls(): void
    {
        $this->add_control(
            'dropdown_style_heading',
            [
                'label' => esc_html__('Dropdown', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'dropdown_highlight_color',
            [
                'label' => esc_html__('Highlight', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-select-v2__option:hover' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-select-v2__option--highlight-text' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-select-v2__option--highlight' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .pac-item' => 'color: {{VALUE}}',
                    $this->getWrapper() . ' .listivo-autocomplete-input__option--highlight-text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'dropdown_active_color',
            [
                'label' => esc_html__('Active', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-select-v2__option--active' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-select-v2__option--active:hover' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-select-v2__option--active .listivo-select-v2__checkbox' => 'background-color: {{VALUE}}; border-color: {{VALUE}};',
                    $this->getWrapper() . ' .pac-matched' => 'color: {{VALUE}}',
                    $this->getWrapper() . ' .pac-item:hover' => 'color: {{VALUE}}',
                    $this->getWrapper() . ' .pac-item:hover .pac-item-query' => 'color: {{VALUE}}',
                    $this->getWrapper() . ' .pac-item:hover .pac-matched' => 'color: {{VALUE}}',
                ]
            ]
        );
    }

    private function getWrapper(): string
    {
        if (is_rtl()) {
            return '[dir] {{WRAPPER}}';
        }

        return '{{WRAPPER}}';
    }

    private function addImagePlaceholderControls(): void
    {
        $this->add_control(
            'image_placeholder_heading',
            [
                'label' => esc_html__('Image placeholder', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'image_placeholder_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-image-placeholder' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'image_placeholder_icon_color',
            [
                'label' => esc_html__('Icon color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-image-placeholder__icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'image_placeholder_text_color',
            [
                'label' => esc_html__('Text color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-image-placeholder__text' => 'color: {{VALUE}};',
                ]
            ]
        );
    }

}