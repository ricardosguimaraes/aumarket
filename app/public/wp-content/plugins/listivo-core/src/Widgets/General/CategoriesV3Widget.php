<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\LimitControl;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\HeadingV2Controls;

class CategoriesV3Widget extends BaseGeneralWidget
{
    use HeadingV2Controls;
    use LimitControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'categories_v3';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Categories V3', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addHeadingControls();

        $this->addLimitControl(esc_html__('Items number', 'listivo-core'), 4);

        $this->addCategoriesControl();

        $this->endControlsSection();

        $this->addStyleSection();
    }

    private function addShowPatternControl(): void
    {
        $this->add_control(
            'show_pattern',
            [
                'label' => esc_html__('Display background pattern', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    /**
     * @return bool
     */
    public function showPattern(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_pattern'));
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

        $this->addShowPatternControl();

        $this->add_control(
            'text_heading',
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
                    '{{WRAPPER}} .listivo-category-v3__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'text_color_hover',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v3__item:hover .listivo-category-v3__item-name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'count_heading',
            [
                'label' => esc_html__('Count', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v3__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'count_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v3__count' => 'background: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

}