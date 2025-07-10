<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\CategoriesControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class CategoriesV1Widget extends BaseGeneralWidget
{
    use CategoriesControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'categories_v1';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Categories V1', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addViewAllControls();

        $this->addCategoriesControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addHoverMaskControls();

        $this->addLabelStyleControls();

        $this->addArrowStyleControls();

        $this->addViewAllStyleControls();

        $this->endControlsSection();
    }

    private function addViewAllControls(): void
    {
        $this->add_control(
            'show_view_all',
            [
                'label' => esc_html__('Display "View All" button', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'view_all_text',
            [
                'label' => esc_html__('View All Text', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
                'default' => "Didn't find the right category?",
                'condition' => [
                    'show_view_all' => '1',
                ]
            ]
        );

        $this->add_control(
            'view_all_style',
            [
                'label' => esc_html__('Style', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'style_1' => esc_html__('Style 1', 'listivo-core'),
                    'style_2' => esc_html__('Style 2', 'listivo-core'),
                    'style_3' => esc_html__('Style 3', 'listivo-core'),
                ],
                'default' => 'style_1',
                'condition' => [
                    'show_view_all' => '1',
                ]
            ]
        );

        $this->add_control(
            'view_all_image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
                'condition' => [
                    'show_view_all' => '1',
                    'view_all_style' => ['style_1', 'style_3'],
                ]
            ]
        );
    }

    /**
     * @return bool
     */
    public function showViewAll(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_view_all'));
    }

    /**
     * @return string
     */
    public function getViewAllText(): string
    {
        return (string)$this->get_settings_for_display('view_all_text');
    }

    /**
     * @return string
     */
    public function getViewAllImage(): string
    {
        $image = $this->get_settings_for_display('view_all_image');

        return $image['url'] ?? '';
    }

    /**
     * @return bool
     */
    public function isViewStyle2(): bool
    {
        return $this->get_settings_for_display('view_all_style') === 'style_2';
    }

    /**
     * @return bool
     */
    public function isViewStyle3(): bool
    {
        return $this->get_settings_for_display('view_all_style') === 'style_3';
    }

    private function addLabelStyleControls(): void
    {
        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v1__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-category-v1__label',
            ]
        );
    }

    private function addHoverMaskControls(): void
    {
        $this->add_control(
            'hover_mask_heading',
            [
                'label' => esc_html__('Hover mask', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'mask_opacity',
            [
                'label' => esc_html__('Opacity', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v1:hover .listivo-category-v1__image:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_control(
            'mask_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v1__image:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addViewAllStyleControls(): void
    {
        $this->add_control(
            'view_all_heading',
            [
                'label' => esc_html__('View all', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'view_all_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v1--view-all:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'view_all_opacity',
            [
                'label' => esc_html__('Opacity', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v1--view-all:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );
    }

    private function addArrowStyleControls(): void
    {
        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v1__arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v1__arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

}