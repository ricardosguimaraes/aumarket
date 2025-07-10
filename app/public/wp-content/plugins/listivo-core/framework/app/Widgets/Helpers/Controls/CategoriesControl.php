<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

trait CategoriesControl
{
    use Control;

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
            'label',
            [
                'label' => tdf_admin_string('label'),
                'type' => Controls_Manager::TEXT,
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
                    'label' => $category['label'],
                    'name' => $term->getName(),
                    'url' => $term->getUrl(),
                ];
            })
            ->filter(static function ($term) {
                return $term !== false && $term !== null;
            });
    }
}