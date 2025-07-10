<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Category;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BlogWidgetStyleControls;

class BlogCategoriesWidget extends BaseGeneralWidget
{
    use BlogWidgetStyleControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'blog_categories';
    }

    public function getName(): string
    {
        return esc_html__('Blog categories', 'listivo-core');
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return tdf_collect(get_categories($this->getQueryCategoriesArgs()))->map(static function ($category) {
            return new Category($category);
        });
    }

    private function getQueryCategoriesArgs(): array
    {
        $args = [
            'taxonomy' => 'category',
        ];

        if (!$this->includeSubcategories()) {
            $args['parent'] = 0;
        }

        $args['hide_empty'] = $this->hideEmptyCategories();

        if ($this->orderCategoriesBy() === 'count') {
            $args['orderby'] = 'count';
            $args['order'] = 'DESC';
        }

        if ($this->orderCategoriesBy() === 'name') {
            $args['orderby'] = 'name';
            $args['order'] = 'ASC';
        }

        if ($this->orderCategoriesBy() === 'id') {
            $args['orderby'] = 'id';
            $args['order'] = 'ASC';
        }

        return apply_filters(tdf_prefix().'/widget/blog_categories/args', $args);
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addControlOnlyMainCategories();

        $this->addHideEmptyCategoriesControl();

        $this->addOrderCategoriesByControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addBlogWidgetStyleControls();

        $this->addNameStyleControls();

        $this->addNumberStyleControls();

        $this->endControlsSection();
    }

    private function addNameStyleControls(): void
    {
        $this->add_control(
            'name_heading',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .listivo-sidebar-list__label',
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-sidebar-list__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'name_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-sidebar-list__item:hover .listivo-sidebar-list__label' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-sidebar-list__item:hover .listivo-sidebar-list__label:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addNumberStyleControls(): void
    {
        $this->add_control(
            'number_heading',
            [
                'label' => esc_html__('Number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'number_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-sidebar-list__count' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'number_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-sidebar-list__count' => 'background: {{VALUE}};'
                ]
            ]
        );
    }

    private function addControlOnlyMainCategories(): void
    {
        $this->add_control(
            'only_main_categories',
            [
                'label' => esc_html__('Only Main Categories', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listivo-core'),
                'label_off' => esc_html__('No', 'listivo-core'),
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    private function includeSubcategories(): bool
    {
        return empty((int)$this->get_settings_for_display('only_main_categories'));
    }

    private function addHideEmptyCategoriesControl(): void
    {
        $this->add_control(
            'hide_empty_categories',
            [
                'label' => esc_html__('Hide Empty Categories', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'listivo-core'),
                'label_off' => esc_html__('No', 'listivo-core'),
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    private function hideEmptyCategories(): bool
    {
        return !empty((int)$this->get_settings_for_display('hide_empty_categories'));
    }

    private function addOrderCategoriesByControl(): void
    {
        $this->add_control(
            'order_categories_by',
            [
                'label' => esc_html__('Order Categories By', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'name' => esc_html__('Name', 'listivo-core'),
                    'count' => esc_html__('Count', 'listivo-core'),
                    'id' => esc_html__('ID', 'listivo-core'),
                ],
                'default' => 'name',
            ]
        );
    }

    private function orderCategoriesBy(): string
    {
        $orderBy = (string)$this->get_settings_for_display('order_categories_by');
        if (!in_array($orderBy, ['name', 'count', 'id'], true)) {
            return 'name';
        }

        return $orderBy;
    }

}