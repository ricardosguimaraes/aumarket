<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class HierarchicalTermsWidget extends BaseGeneralWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'hierarchical_terms';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hierarchical Terms', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLimitControl();

        $this->addOrderControl();

        $this->addTermsControl();

        $this->endControlsSection();
    }

    /**
     * @return array
     */
    private function getTaxonomyControlOptions(): array
    {
        $options = [];

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $options[$taxonomyField->getKey()] = $taxonomyField->getName();
        }

        return $options;
    }

    private function addTermsControl(): void
    {
        $terms = new Repeater();

        $terms->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $terms->add_control(
            'taxonomy',
            [
                'label' => esc_html__('Taxonomy', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getTaxonomyControlOptions(),
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $terms->add_control(
                'term_' . $taxonomyField->getKey(),
                [
                    'label' => esc_html__('Term', 'listivo-core'),
                    'type' => SelectRemoteControl::TYPE,
                    'source' => $taxonomyField->getApiEndpoint(),
                    'prevent_empty' => false,
                    'condition' => [
                        'taxonomy' => $taxonomyField->getKey(),
                    ]
                ]
            );
        }

        $this->add_control(
            'terms',
            [
                'label' => esc_html__('Terms', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $terms->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getTerms(): Collection
    {
        $terms = tdf_collect();

        $termData = $this->get_settings_for_display('terms');
        if (!is_array($termData) || empty($termData)) {
            return $terms;
        }

        return tdf_collect($termData)
            ->map(function ($term) {
                if (empty($term['taxonomy'])) {
                    return false;
                }

                $taxonomyKey = $term['taxonomy'];
                if (empty($term['term_' . $taxonomyKey])) {
                    return false;
                }

                $termId = (int)$term['term_' . $taxonomyKey];
                $termObject = tdf_term_factory()->create($termId);
                if (!$termObject) {
                    return false;
                }

                $query = tdf_query_terms($termObject->getTaxonomyKey())
                    ->setParent($termObject->getId())
                    ->take($this->getLimit());

                if ($this->getOrder() === 'name') {
                    $query->orderByName();
                } else {
                    $query->orderByCount();
                }

                return [
                    'icon' => $term['icon'],
                    'term' => $termObject,
                    'terms' => $query->get(),
                ];
            })->filter(static function ($term) {
                return $term !== false && $term !== null;
            });
    }

    private function addLimitControl(): void
    {
        $this->add_control(
            'limit',
            [
                'label' => esc_html__('Limit', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 4,
            ]
        );
    }

    /**
     * @return int
     */
    private function getLimit(): int
    {
        $limit = (int)$this->get_settings_for_display('limit');
        if (empty($limit)) {
            return 4;
        }

        return $limit;
    }

    private function addOrderControl(): void
    {
        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order By', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'name' => esc_html__('Name', 'listivo-core'),
                    'count' => esc_html__('Count', 'listivo-core'),
                ],
                'default' => 'count',
            ]
        );
    }

    /**
     * @return string
     */
    private function getOrder(): string
    {
        $order = $this->get_settings_for_display('order');
        if (empty($order)) {
            return 'count';
        }

        return $order;
    }

}