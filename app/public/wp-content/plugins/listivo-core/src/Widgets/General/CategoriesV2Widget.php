<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class CategoriesV2Widget extends BaseGeneralWidget
{
    use TextControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'categories_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Categories V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTextControl(esc_html__('Label', 'listivo-core'));

        $this->addCategoriesControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addLabelStyleControls();

        $this->addIconStyleControls();

        $this->endControlsSection();
    }

    protected function addCategoriesControl(): void
    {
        $terms = new Repeater();

        $terms->add_control(
            'image',
            [
                'label' => tdf_admin_string('image'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $terms->add_control(
            'taxonomy',
            [
                'label' => tdf_admin_string('taxonomy'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('taxonomy_list'),
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $terms->add_control(
                'term_' . $taxonomyField->getKey(),
                [
                    'label' => tdf_admin_string('term'),
                    'type' => SelectRemoteControl::TYPE,
                    'source' => $taxonomyField->getApiEndpoint(),
                    'multiple' => false,
                    'condition' => [
                        'taxonomy' => $taxonomyField->getKey(),
                    ]
                ]
            );
        }

        $this->add_control(
            'terms',
            [
                'label' => tdf_admin_string('categories'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $terms->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getCategories(): Collection
    {
        $categories = $this->get_settings_for_display('terms');
        if (empty($categories) || !is_array($categories)) {
            return tdf_collect();
        }

        return tdf_collect($categories)
            ->map(static function ($category) {
                if (empty($category['taxonomy'])) {
                    return false;
                }

                $termId = (int)$category['term_' . $category['taxonomy']];
                if (empty($termId)) {
                    return false;
                }

                $term = tdf_term_factory()->create($termId);
                if (!$term) {
                    return false;
                }

                return [
                    'image' => $category['image']['url'] ?? '',
                    'name' => $term->getName(),
                    'url' => $term->getUrl(),
                ];
            })
            ->filter(static function ($term) {
                return $term !== false && $term !== null;
            });
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
                    '{{WRAPPER}} .listivo-category-v2__label' => 'color: {{VALUE}}',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-category-v2__label',
            ]
        );
    }

    private function addIconStyleControls(): void
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
                    '{{WRAPPER}} .listivo-category-v2__arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v2:hover .listivo-category-v2__arrow path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_background_color',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v2__arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'icon_background_hover_color',
            [
                'label' => esc_html__('Background hover', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-category-v2:hover .listivo-category-v2__arrow' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

}