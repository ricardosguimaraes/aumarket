<?php

namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ShareIconsStyleSection;

class MenuV2Widget extends \Tangibledesign\Framework\Widgets\General\MenuWidget
{
    use ShareIconsStyleSection;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'menu_v2';
    }

    /**
     * @return string
     */
    protected function getTemplateDirectory(): string
    {
        return 'general/menuv2/';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Menu V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addContentControls();

        $this->addMenuStyleControl();

        $this->addMenuHeightControl();

        $this->addLogoHeightControl();

        $this->addCtaButtonStyleControl();

        $this->addMenuStretchControl();

        $this->addMobileBreakpointControl();

        $this->endControlsSection();

        $this->addDesktopMenuStyleControls();

        $this->addStickyMenuControls();

        $this->addDesktopMenuItemControls();

        $this->addStickyDesktopMenuItemControls();

        $this->addDesktopSubmenuItemControls();

        $this->addUserMenuStyleControls();

        $this->addMobileMenuControls();

        $this->addMobileMenuItemControls();
    }

    private function addDesktopMenuStyleControls(): void
    {
        $this->startStyleControlsSection('desktop_menu_style');

        $this->addBackgroundColorControl();

        $this->addBottomBorderColor();

        $this->add_control(
            'user_link_color',
            [
                'label' => esc_html__('User link', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__account-link' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'desktop_menu_user_icon_heading',
            [
                'label' => esc_html__('User Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'user_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__avatar path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'user_icon_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__avatar' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->addHamburgerIconStyleControls();

        $this->endControlsSection();
    }

    private function addBackgroundColorControl(): void
    {
        $this->add_control(
            'background_color',
            [
                'label' => esc_html__('Background color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2' => 'background-color: {{VALUE}};'
                ]
            ]
        );
    }

    private function addBottomBorderColor(): void
    {
        $this->add_control(
            'bottom_border_color',
            [
                'label' => esc_html__('Bottom border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__line' => 'background-color: {{VALUE}};'
                ]
            ]
        );
    }

    /**
     * @return string
     */
    public function getMenuStyle(): string
    {
        $style = $this->get_settings_for_display('menu_style');
        if (empty($style)) {
            return 'dark';
        }

        return $style;
    }

    protected function addMenuStyleControl(): void
    {
        $this->add_control(
            'menu_style',
            [
                'label' => esc_html__('Style', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'light' => esc_html__('Light', 'listivo-core'),
                    'dark' => esc_html__('Dark', 'listivo-core'),
                ],
                'default' => 'dark',
            ]
        );
    }

    protected function addLogoHeightControl(): void
    {
        $this->add_control(
            'logo_height',
            [
                'label' => esc_html__('Logo Height (px)', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__logo' => 'height: {{SIZE}}{{UNIT}};',
                ]
            ]
        );
    }

    protected function addMenuHeightControl(): void
    {
        $this->add_control(
            'menu_height',
            [
                'label' => esc_html__('Menu Height', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 400,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-menu-v2 .listivo-menu-v2__items > .listivo-menu-v2__item > a ' => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .listivo-menu-v2 .listivo-menu-v2__account' => 'height: {{SIZE}}{{UNIT}};',
                    '.listivo-menu-sticky .listivo-menu-sticky-holder' => 'height: {{SIZE}}{{UNIT}};',
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
            'main_class' => 'listivo-menu-v2__items',
            'template_path' => 'templates/widgets/general/menuv2/',
            'menu_element_class' => tdf_prefix().'-menu-v2__item ',
            'menu_element_depth_classes' => [
                tdf_prefix().'-menu-v2__item--depth-',
            ],
            'menu_level_class' => tdf_prefix().'-menu-v2__submenu',
            'menu_level_depth_classes' => [
                tdf_prefix().'-menu-v2__submenu--depth-',
            ]
        ];
    }

    /**
     * @return array
     */
    public function getMenuMobileArgs(): array
    {
        return [
            'main_class' => 'listivo-menu-mobile-v2__items',
            'template_path' => 'templates/widgets/general/menuv2/mobile/',
            'menu_element_class' => tdf_prefix().'-menu-mobile-v2__item ',
            'menu_element_depth_classes' => [
                tdf_prefix().'-menu-mobile-v2__item--depth-',
            ],
            'menu_level_class' => tdf_prefix().'-menu-mobile-v2__submenu',
            'menu_level_depth_classes' => [
                tdf_prefix().'-menu-mobile-v2__submenu--depth-',
            ]
        ];
    }

    private function addCtaButtonStyleControl(): void
    {
        $this->add_control(
            'cta_type',
            [
                'label' => esc_html__('CTA Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'button' => esc_html__('Button', 'listivo-core'),
                    'phone' => esc_html__('Phone', 'listivo-core'),
                ],
                'default' => 'button',
            ]
        );

        $this->add_control(
            'cta_button_style',
            [
                'label' => esc_html__('CTA Button Style', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'primary_1' => esc_html__('Primary 1', 'listivo-core'),
                    'primary_2' => esc_html__('Primary 2', 'listivo-core'),
                ],
                'default' => 'primary_2',
                'condition' => [
                    'cta_type' => 'button',
                ]
            ]
        );
    }

    /**
     * @return string
     */
    public function getCtaType(): string
    {
        return $this->get_settings_for_display('cta_type');
    }

    /**
     * @return string
     */
    public function getCtaButtonStyle(): string
    {
        $style = $this->get_settings_for_display('cta_button_style');
        if (empty($style)) {
            return 'primary_2';
        }

        return $style;
    }

    private function addMenuStretchControl(): void
    {
        $this->add_control(
            'menu_stretch',
            [
                'label' => esc_html__('Stretch', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__container' => 'max-width: 100% !important;'
                ]
            ]
        );
    }

    private function addMobileBreakpointControl(): void
    {
        $this->add_control(
            'mobile_breakpoint',
            [
                'label' => esc_html__('Mobile Breakpoint (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
            ]
        );
    }

    /**
     * @return int
     */
    public function getMobileBreakpoint(): int
    {
        $breakpoint = (int)$this->get_settings_for_display('mobile_breakpoint');
        if (empty($breakpoint)) {
            return 1120;
        }

        return $breakpoint;
    }

    protected function render(): void
    {
        parent::render();

        if (empty($this->getMobileBreakpoint())) {
            return;
        }
        ?>
        <style>
            @media (min-width: <?php echo esc_html($this->getMobileBreakpoint()); ?>px) {
                .listivo-menu-v2--simple .listivo-menu-v2__container {
                    flex-direction: row;
                }

                .listivo-menu-v2--simple .listivo-menu-v2__right {
                    display: flex;
                }

                .listivo-menu-v2__button {
                    display: block;
                }

                .listivo-menu-v2__account:hover .listivo-user-dropdown {
                    opacity: 1;
                    visibility: visible;
                    display: flex;
                }

                .listivo-menu-v2__mobile-button {
                    display: none;
                }

                .listivo-menu-v2__separator {
                    display: block;
                }

                .listivo-menu-v2__account-link {
                    display: block;
                }

                .listivo-menu-v2__items {
                    display: flex;
                }
            }
        </style>
        <?php
    }

    private function addDesktopMenuItemControls(): void
    {
        $this->startStyleControlsSection('desktop_menu_item_style', esc_html__('Desktop Menu Item', 'listivo-core'));

        $this->add_control(
            'menu_item_circle_color',
            [
                'label' => esc_html__('Hover dot color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->start_controls_tabs('menu_item_style_tabs');

        $this->start_controls_tab(
            'menu_item',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'menu_item_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'menu_item_arrow_color',
            [
                'label' => esc_html__('Arrow color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'menu_item_typography',
                'selector' => '{{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'menu_item_hover_style_tab',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'menu_item_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'menu_item_arrow_hover_color',
            [
                'label' => esc_html__('Arrow color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item:hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'menu_item_hover_typography',
                'selector' => '{{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }

    private function addDesktopSubmenuItemControls(): void
    {
        $this->startStyleControlsSection('desktop_submenu_item_style',
            esc_html__('Desktop Submenu Item', 'listivo-core'));

        $this->start_controls_tabs('submenu_item_style_tabs');

        $this->start_controls_tab(
            'submenu_item',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'submenu_item_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__submenu .listivo-menu-v2__item' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'submenu_item_arrow_color',
            [
                'label' => esc_html__('Arrow color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__submenu .listivo-menu-v2__item path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'submenu_item_typography',
                'selector' => '{{WRAPPER}} .listivo-menu-v2__submenu .listivo-menu-v2__item',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'submenu_item_hover_style_tab',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'submenu_item_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__submenu .listivo-menu-v2__item:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'submenu_item_arrow_hover_color',
            [
                'label' => esc_html__('Arrow color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__submenu .listivo-menu-v2__item:hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'submenu_item_arrow_hover_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__submenu .listivo-menu-v2__item:hover a' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'submenu_item_hover_typography',
                'selector' => '{{WRAPPER}} .listivo-menu-v2__submenu .listivo-menu-v2__item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }

    private function addMobileMenuControls(): void
    {
        $this->startStyleControlsSection('mobile_menu_style', esc_html__('Mobile Menu', 'listivo-core'));

        $this->add_control(
            'mobile_menu_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_top_bg',
            [
                'label' => esc_html__('Top background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2__top' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_close_button_heading',
            [
                'label' => esc_html__('Close Button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'mobile_menu_close_button_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2__close path' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_close_button_border_color',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2__close' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_info_label_heading',
            [
                'label' => esc_html__('Contact information label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'mobile_menu_info_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2__data-label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mobile_menu_info_label_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-menu-mobile-v2__data-label',
            ]
        );

        $this->add_control(
            'mobile_menu_info_value_heading',
            [
                'label' => esc_html__('Contact information value', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'mobile_menu_info_value_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2__data-value' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-menu-mobile-v2__data-value a' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'mobile_menu_info_value_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-menu-mobile-v2__data-value',
            ]
        );

        $this->add_control(
            'mobile_menu_social_icons_heading',
            [
                'label' => esc_html__('Social icons', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->addSocialShareIconsControls();

        $this->endControlsSection();
    }

    private function addMobileMenuItemControls(): void
    {
        $this->startStyleControlsSection('mobile_menu_item_style', esc_html__('Mobile Menu Item', 'listivo-core'));

        $this->add_control(
            'mobile_menu_item_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2__items .listivo-menu-mobile-v2__item a' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_item_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2__item' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_item_sep',
            [
                'label' => esc_html__('Separator', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2__item a' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mobile_menu_item_arrow_color',
            [
                'label' => esc_html__('Arrow color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-mobile-v2__items .listivo-menu-mobile-v2__item path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'mobile_menu_item_typography',
                'selector' => '{{WRAPPER}} .listivo-menu-mobile-v2__items .listivo-menu-mobile-v2__item a',
            ]
        );

        $this->endControlsSection();
    }

    private function addUserMenuStyleControls(): void
    {
        $this->startStyleControlsSection('menu_user_style', esc_html__('User Menu', 'listivo-core'));

        $this->add_control(
            'menu_user_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'menu_user_border_color',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'menu_user_separator_color',
            [
                'label' => esc_html__('Separator', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__separator' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'menu_user_item_heading',
            [
                'label' => esc_html__('Item', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('user_menu_item_tabs');

        $this->start_controls_tab(
            'user_menu_item_tab_normal',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'user_item_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'user_item_icon_color',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__icon-fill' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-user-dropdown__icon-stroke' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_item_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-user-dropdown__label',
            ]
        );

        $this->add_control(
            'user_item_count_heading',
            [
                'label' => esc_html__('Count', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'user_item_count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'user_item_count_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__count' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_item_count_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-user-dropdown__count',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'user_menu_item_tab_hover',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'user_item_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__item:hover .listivo-user-dropdown__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'user_item_hover_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__item:hover' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'user_item_icon_hover_color',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__item:hover .listivo-user-dropdown__icon-fill' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-user-dropdown__item:hover .listivo-user-dropdown__icon-stroke' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_item_hover_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-user-dropdown__item:hover .listivo-user-dropdown__label',
            ]
        );

        $this->add_control(
            'user_item_count_hover_heading',
            [
                'label' => esc_html__('Count', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'user_item_count_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__item:hover .listivo-user-dropdown__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'user_item_count_hover_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-user-dropdown__item:hover .listivo-user-dropdown__count' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'user_item_count_hover_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-user-dropdown__item:hover .listivo-user-dropdown__count',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }

    private function addStickyMenuControls(): void
    {
        $this->startStyleControlsSection('sticky_menu_style', esc_html__('Sticky Menu', 'listivo-core'));

        $this->add_control(
            'sticky_menu_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sticky_menu_bottom_border_color',
            [
                'label' => esc_html__('Bottom border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__line' => 'background-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'sticky_menu_user_icon_heading',
            [
                'label' => esc_html__('User Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'sticky_user_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__avatar path' => 'fill: {{VALUE}};',
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__account-link' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sticky_user_icon_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__avatar' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addStickyDesktopMenuItemControls(): void
    {
        $this->startStyleControlsSection('sticky_desktop_menu_item_style',
            esc_html__('Sticky Desktop Menu Item', 'listivo-core'));

        $this->add_control(
            'sticky_menu_item_circle_color',
            [
                'label' => esc_html__('Circle color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->start_controls_tabs('sticky_menu_item_style_tabs');

        $this->start_controls_tab(
            'sticky_menu_item',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'sticky_menu_item_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sticky_menu_item_arrow_color',
            [
                'label' => esc_html__('Arrow color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'sticky_menu_item_typography',
                'selector' => '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item',
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'sticky_menu_item_hover_style_tab',
            [
                'label' => esc_html__('Hover', 'listivo-core'),
            ]
        );

        $this->add_control(
            'sticky_menu_item_hover_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item:hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'sticky_menu_item_arrow_hover_color',
            [
                'label' => esc_html__('Arrow color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item:hover path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'sticky_menu_item_hover_typography',
                'selector' => '.listivo-menu-sticky--active {{WRAPPER}} .listivo-menu-v2__items > .listivo-menu-v2__item:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->endControlsSection();
    }

    /**
     * @return void
     */
    private function addHamburgerIconStyleControls(): void
    {
        $this->add_control(
            'hamburger_icon_style_heading',
            [
                'label' => esc_html__('Hamburger Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'hamburger_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__mobile-button svg path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'hamburger_icon_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-menu-v2__mobile-button' => 'border-color: {{VALUE}};',
                ]
            ]
        );
    }

}