<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class CategoriesV5Widget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'categories_v5';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Categories V5', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addCategoriesControl();

        $this->endControlsSection();

        $this->addStyleSection();
    }

    protected function addCategoriesControl(): void
    {
        $fields = new Repeater();

        $fields->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $fields->add_control(
            'taxonomy',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getCategoriesControlOptions(),
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomy) {
            $fields->add_control(
                'term_' . $taxonomy->getKey(),
                [
                    'label' => esc_html__('Category', 'listivo-core'),
                    'type' => Controls_Manager::SELECT,
                    'options' => $taxonomy->getMainTermsList(),
                    'condition' => [
                        'taxonomy' => $taxonomy->getKey(),
                    ]
                ]
            );
        }

        $fields->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );

        $this->add_control(
            'categories',
            [
                'label' => esc_html__('Categories', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    private function getCategoriesControlOptions(): array
    {
        $options = [];

        foreach (tdf_taxonomy_fields() as $taxonomy) {
            $options[$taxonomy->getKey()] = $taxonomy->getName();
        }

        return $options;
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        $cats = $this->get_settings_for_display('categories');
        if (!is_array($cats) || empty($cats)) {
            return tdf_collect();
        }

        return tdf_collect($cats)
            ->map(function ($cat) {
                if (empty($cat['taxonomy'])) {
                    return false;
                }

                $taxonomy = tdf_taxonomy_fields()->find(static function ($taxonomy) use ($cat) {
                    return $taxonomy->getKey() === $cat['taxonomy'];
                });

                if (!$taxonomy instanceof TaxonomyField) {
                    return false;
                }

                $termKey = $cat['term_' . $taxonomy->getKey()];
                if (empty($termKey)) {
                    return false;
                }

                $termId = (int)str_replace(tdf_prefix() . '_', '', $termKey);
                if (empty($termId)) {
                    return false;
                }

                $term = tdf_term_factory()->create($termId);
                if (!$term instanceof CustomTerm) {
                    return false;
                }

                return [
                    'icon' => $cat['icon'],
                    'description' => $cat['description'],
                    'term' => $term,
                ];
            })
            ->filter(static function ($cat) {
                return $cat !== false;
            });
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->addIconControl();

        $this->addLabelControls();

        $this->addTextControls();

        $this->endControlsSection();
    }

    private function addIconControl(): void
    {
        $this->add_control(
            'icon_heading',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'icon_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v5__circle' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v5__circle' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_border_width',
            [
                'label' => esc_html__('Border width (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v5__circle' => 'border-width: {{VALUE}}px;',
                ]
            ]
        );
    }

    private function addLabelControls(): void
    {
        $this->add_control(
            'label_label',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v5__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .listivo-category-v5__label',
            ]
        );
    }

    private function addTextControls(): void
    {
        $this->add_control(
            'text_label',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v5__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .listivo-category-v5__text',
            ]
        );
    }

}