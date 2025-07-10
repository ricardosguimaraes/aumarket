<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

class MenuWidget extends \Tangibledesign\Framework\Widgets\General\MenuWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'menu';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('menu');
    }

    /**
     * @return string
     */
    protected function getTemplateDirectory(): string
    {
        return 'general/menu/';
    }

    protected function addDesktopMenuStyleControls(): void
    {
        $this->start_controls_section(
            'desktop_menu',
            [
                'label' => tdf_admin_string('desktop_menu'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'menu_desktop_bg_color',
            [
                'label' => tdf_admin_string('background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__wrapper' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'menu_link_typography',
                'label' => tdf_admin_string('link_typography'),
                'selector' => '{{WRAPPER}} .' . tdf_prefix() . '-menu-item-depth-0 > *',
            ]
        );


        $this->add_control(
            'menu_link_color',
            [
                'label' => tdf_admin_string('link_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-menu > .menu-item > .' . tdf_prefix() . '-menu__link' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu-desktop-login-register-link .' . tdf_prefix() . '-menu-item-depth-0 > a' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu-desktop-login-register-link .' . tdf_prefix() . '-menu-user-icon' => 'stroke: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'menu_dropdown_color',
            [
                'label' => tdf_admin_string('dropdown_arrow_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__wrapper .' . tdf_prefix() . '-menu > .menu-item-has-children > .' . tdf_prefix() . '-menu__link:after' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'menu_line_hover_color',
            [
                'label' => tdf_admin_string('hover_line_about_link_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu-hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'menu_link_hover_color',
            [
                'label' => tdf_admin_string('link_hover_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-menu > .menu-item:hover > .' . tdf_prefix() . '-menu__link' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-menu-desktop-login-register-link__register-text:hover !important' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-menu-desktop-login-register-link__login-text:hover !important' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-menu-desktop-dashboard-link:hover !important' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'menu_dropdown_hover_color',
            [
                'label' => tdf_admin_string('dropdown_arrow_hover_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__wrapper .' . tdf_prefix() . '-menu > .menu-item-has-children:hover > .' . tdf_prefix() . '-menu__link:after' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'menu_user_icon_color',
            [
                'label' => tdf_admin_string('user_icon_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu-user-icon' => 'stroke: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'menu_login_register_separator_color',
            [
                'label' => tdf_admin_string('login_register_separator_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu-desktop-login-register-link__separator' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    private function addButtonDesktopStyleControls(): void
    {
        $this->start_controls_section(
            'button_desktop_style',
            [
                'label' => tdf_admin_string('button_cta_desktop'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => tdf_admin_string('color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-primary-button.' . tdf_prefix() . '-button--menu-submit' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => tdf_admin_string('color_hover'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-primary-button.' . tdf_prefix() . '-button--menu-submit:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => tdf_admin_string('background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-primary-button.' . tdf_prefix() . '-button--menu-submit' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_background_color_hover',
            [
                'label' => tdf_admin_string('background_color_hover'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-primary-button.' . tdf_prefix() . '-button--menu-submit:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_icon',
            [
                'label' => tdf_admin_string('icon'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $this->add_control(
            'button_icon_color',
            [
                'label' => esc_html__('Button Icon Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-button--menu-submit i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-button--menu-submit svg' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_icon_background',
            [
                'label' => esc_html__('Button Icon Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-primary-button__icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_icon_background_hover',
            [
                'label' => esc_html__('Button Icon Background Hover', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-primary-button__icon:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'button_border_heading',
            [
                'label' => tdf_admin_string('border'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'label' => tdf_admin_string('border'),
                'selector' => '.' . tdf_prefix() . '-primary-button.' . tdf_prefix() . '-button--menu-submit'
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => tdf_admin_string('border_radius'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-primary-button.' . tdf_prefix() . '-button--menu-submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'button_border_heading_hover',
            [
                'label' => tdf_admin_string('border_hover'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border_hover',
                'label' => tdf_admin_string('border_hover'),
                'selector' => '.' . tdf_prefix() . '-primary-button.' . tdf_prefix() . '-button--menu-submit:hover'
            ]
        );

        $this->add_responsive_control(
            'button_border_radius_hover',
            [
                'label' => tdf_admin_string('border_radius_hover'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-primary-button.' . tdf_prefix() . '-button--menu-submit:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();
    }

    private function addStyleSections(): void
    {
        $this->addDesktopMenuStyleControls();

        $this->addDesktopStickyMenuStyleControls();

        $this->addDesktopSubMenuStyleControls();

        $this->addMobileMenuClosedStyleControls();

        $this->addMobileMenuOpenStyleControls();

        $this->addButtonDesktopStyleControls();

        $this->addButtonMobileStyleControls();
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addContentControls();

        $this->addMenuHeightControl();

        $this->addLogoHeightControl();

        $this->addStickyLogoHeightControl();

        $this->endControlsSection();

        $this->addStyleSections();
    }


    protected function addButtonMobileStyleControls(): void
    {
        $this->start_controls_section(
            'button_mobile_style',
            [
                'label' => tdf_admin_string('button_cta_mobile'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'button_mobile_color',
            [
                'label' => tdf_admin_string('color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__open__top__submit-button .' . tdf_prefix() . '-primary-button' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'button_mobile_color_hover',
            [
                'label' => tdf_admin_string('color_hover'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__open__top__submit-button .' . tdf_prefix() . '-primary-button:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'button_mobile_background',
            [
                'label' => tdf_admin_string('background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__open__top__submit-button .' . tdf_prefix() . '-primary-button' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'button_mobile_background_hover',
            [
                'label' => tdf_admin_string('background_color_hover'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__open__top__submit-button .' . tdf_prefix() . '-primary-button:hover' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'button_mobile_icon',
            [
                'label' => tdf_admin_string('icon'),
                'type' => Controls_Manager::ICONS
            ]
        );

        $this->add_control(
            'button_mobile_border_heading',
            [
                tdf_admin_string('border'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_mobile_border',
                'label' => tdf_admin_string('border'),
                'selector' => '.' . tdf_prefix() . '-mobile-menu__open__top__submit-button .' . tdf_prefix() . '-primary-button'
            ]
        );

        $this->add_responsive_control(
            'button_mobile_border_radius',
            [
                'label' => tdf_admin_string('border_radius'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__open__top__submit-button .' . tdf_prefix() . '-primary-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->add_control(
            'button_mobile_border_heading_hover',
            [
                'label' => tdf_admin_string('border_hover'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_mobile_border_hover',
                'label' => tdf_admin_string('border_hover'),
                'selector' => '.' . tdf_prefix() . '-mobile-menu__open__top__submit-button .' . tdf_prefix() . '-primary-button:hover'
            ]
        );

        $this->add_responsive_control(
            'button_mobile_border_radius_hover',
            [
                'label' => tdf_admin_string('border_radius_hover'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__open__top__submit-button .' . tdf_prefix() . '-primary-button:hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function addDesktopStickyMenuStyleControls(): void
    {
        $this->start_controls_section(
            'menu_desktop_menu_sticky',
            [
                'label' => tdf_admin_string('desktop_sticky_menu'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'menu_desktop_sticky_bg_color',
            [
                'label' => tdf_admin_string('background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.' . tdf_prefix() . '-menu-sticky-active {{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-menu__wrapper' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'sticky_menu_link_typography',
                'label' => tdf_admin_string('link_typography'),
                'selector' => '.' . tdf_prefix() . '-menu-sticky-active {{WRAPPER}} .' . tdf_prefix() . '-menu-item-depth-0 > *',
            ]
        );


        $this->add_control(
            'sticky_menu_link_color',
            [
                'label' => tdf_admin_string('link_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.' . tdf_prefix() . '-menu-sticky-active {{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-menu > .menu-item > .' . tdf_prefix() . '-menu__link' => 'color: {{VALUE}};',
                    '.' . tdf_prefix() . '-menu-sticky-active {{WRAPPER}} .' . tdf_prefix() . '-menu-desktop-login-register-link a' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sticky_menu_dropdown_color',
            [
                'label' => tdf_admin_string('dropdown_arrow_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.' . tdf_prefix() . '-menu-sticky-active {{WRAPPER}} .' . tdf_prefix() . '-menu__wrapper .' . tdf_prefix() . '-menu > .menu-item-has-children > .' . tdf_prefix() . '-menu__link:after' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'sticky_menu_link_hover_color',
            [
                'label' => tdf_admin_string('link_hover_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.' . tdf_prefix() . '-menu-sticky-active {{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-menu > .menu-item:hover > .' . tdf_prefix() . '-menu__link' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'sticky_menu_dropdown_hover_color',
            [
                'label' => tdf_admin_string('dropdown_arrow_hover_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.' . tdf_prefix() . '-menu-sticky-active {{WRAPPER}} .' . tdf_prefix() . '-menu__wrapper .' . tdf_prefix() . '-menu > .menu-item-has-children:hover > .' . tdf_prefix() . '-menu__link:after' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'sticky_menu_user_icon_color',
            [
                'label' => tdf_admin_string('user_icon_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.' . tdf_prefix() . '-menu-sticky-active {{WRAPPER}} .' . tdf_prefix() . '-menu-user-icon' => 'stroke: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function addDesktopSubMenuStyleControls(): void
    {
        $this->start_controls_section(
            'desktop_submenu',
            [
                'label' => tdf_admin_string('desktop_submenu'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'submenu_bg_color',
            [
                'label' => tdf_admin_string('background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-submenu' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-submenu--level-0:after' => 'border-bottom-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'submenu_border_color',
            [
                'label' => tdf_admin_string('border_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-submenu' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-submenu--level-0:before' => 'border-bottom-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'submenu_shadow',
                'label' => tdf_admin_string('shadow'),
                'selector' => '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-submenu'
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submenu_link_typography',
                'label' => tdf_admin_string('link_typography'),
                'selector' => '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-submenu a'
            ]
        );

        $this->add_control(
            'submenu_link_color',
            [
                'label' => tdf_admin_string('link_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-submenu a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'submenu_link_hover_color',
            [
                'label' => tdf_admin_string('link_hover_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop .' . tdf_prefix() . '-submenu a:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'submenu_separator_control',
            [
                'label' => tdf_admin_string('separator_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__wrapper .' . tdf_prefix() . '-menu .' . tdf_prefix() . '-submenu .' . tdf_prefix() . '-menu__link' => 'border-bottom-color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function addMobileMenuClosedStyleControls(): void
    {
        $this->start_controls_section(
            'mobile_menu_closed',
            [
                'label' => tdf_admin_string('mobile_menu_closed'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'mobile_menu_closed_bg_color',
            [
                'label' => tdf_admin_string('background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__wrapper' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_closed_hamburger_icon_color',
            [
                'label' => tdf_admin_string('hamburger_icon_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu-icon-wrapper svg' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_closed_hamburger_icon_background_color',
            [
                'label' => tdf_admin_string('hamburger_icon_background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu-icon-wrapper' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_closed_user_icon_color',
            [
                'label' => tdf_admin_string('user_icon_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu-user-icon' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_closed_user_icon_background_color',
            [
                'label' => tdf_admin_string('user_icon_background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-user-icon-wrapper' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function addMobileMenuOpenStyleControls(): void
    {
        $this->start_controls_section(
            'mobile_menu_open',
            [
                'label' => tdf_admin_string('mobile_menu_open'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_control(
            'mobile_menu_open_top_bg_color',
            [
                'label' => tdf_admin_string('top_background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__wrapper .' . tdf_prefix() . '-mobile-menu__open .' . tdf_prefix() . '-mobile-menu__open__top' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_open_close_icon_color',
            [
                'label' => tdf_admin_string('close_icon_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__open__top__x svg *' => 'fill: {{VALUE}} !important;'
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_open_bg_color',
            [
                'label' => tdf_admin_string('background_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__wrapper .' . tdf_prefix() . '-mobile-menu__open' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mobile_menu_open_link_typography',
                'label' => tdf_admin_string('link_typography'),
                'selector' => '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__wrapper .' . tdf_prefix() . '-mobile-menu__open .menu-item .' . tdf_prefix() . '-menu__link'
            ]
        );

        $this->add_control(
            'mobile_menu_open_link_color',
            [
                'label' => tdf_admin_string('link_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__wrapper .' . tdf_prefix() . '-mobile-menu__open .menu-item .' . tdf_prefix() . '-menu__link' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_open_submenu_link_color',
            [
                'label' => tdf_admin_string('active_link_color'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-mobile-menu__wrapper .' . tdf_prefix() . '-mobile-menu__open .menu-item.' . tdf_prefix() . '-open > a' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        $class = [tdf_prefix() . '-header'];

        if (tdf_settings()->showMenuCtaButton()) {
            $class[] = tdf_prefix() . '-header--with-submit-button';
        } else {
            $class[] = tdf_prefix() . '-header--no-submit-button';
        }

        if (tdf_settings()->showMenuAccount()) {
            $class[] = tdf_prefix() . '-header--with-dashboard-link';
        } else {
            $class[] = tdf_prefix() . '-header--no-dashboard-link';
        }

        return implode(' ', $class);
    }

    protected function addMenuHeightControl(): void
    {
        $this->add_control(
            'menu_height',
            [
                'label' => tdf_admin_string('menu_height'),
                'type' => Controls_Manager::NUMBER,
                'default' => '107',
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__wrapper' => 'height: {{VALUE}}px;',
                    '{{WRAPPER}} .' . tdf_prefix() . '-menu__desktop' => 'height: {{VALUE}}px;'
                ]
            ]
        );
    }

    protected function addLogoHeightControl(): void
    {
        $this->add_responsive_control(
            'logo_max_height',
            [
                'label' => tdf_admin_string('logo_height'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .' . tdf_prefix() . '-logo img' => 'max-height: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};'
                ]
            ]
        );
    }

    protected function addStickyLogoHeightControl(): void
    {
        $this->add_responsive_control(
            'sticky_logo_height',
            [
                'label' => tdf_admin_string('sticky_logo_height'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '.' . tdf_prefix() . '-menu-sticky-active {{WRAPPER}} .' . tdf_prefix() . '-logo img' => 'height: {{SIZE}}{{UNIT}} !important; max-height: {{SIZE}}{{UNIT}} !important;'
                ]
            ]
        );
    }

    /**
     * @return array
     */
    public function getMenuArgs(): array
    {
        return [
            'menu_element_class' => tdf_prefix() . '-menu-item ' . tdf_prefix() . '-menu__item',
            'menu_element_depth_classes' => [
                tdf_prefix() . '-menu-item-depth-',
                tdf_prefix() . '-menu__item--depth-',
            ],
            'menu_level_class' => tdf_prefix() . '-submenu ' . tdf_prefix() . '-menu__submenu',
            'menu_level_depth_classes' => [
                tdf_prefix() . '-submenu--level-',
                tdf_prefix() . '-menu__submenu--',
            ]
        ];
    }

}