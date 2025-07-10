<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Widgets\General\PopularTermsWidget;
use WP_Term_Query;

trait PopularTermsControls
{
    use LimitControl;

    /**
     * @return Collection|CustomTerm[]
     */
    public function getPopularTerms(): Collection
    {
        $baseTerms = $this->fetchTerms();
        if (empty($baseTerms)) {
            return tdf_collect();
        }

        $limit = $this->getLimit();
        if (empty($limit) || count($baseTerms) < $limit) {
            $limit = count($baseTerms);
        }

        if (empty($limit)) {
            return tdf_collect();
        }

        if ($this->randomize()) {
            $terms = [];
            $termKeys = array_rand($baseTerms, $limit);

            if (is_int($termKeys)) {
                $terms[] = $baseTerms[$termKeys];
            } elseif (!is_array($termKeys)) {
                return tdf_collect();
            } else {
                foreach ($termKeys as $key) {
                    $terms[] = $baseTerms[$key];
                }
            }
        } else {
            $terms = $baseTerms;
        }

        return tdf_collect($terms)->map(static function ($term) {
            return tdf_term_factory()->create($term);
        });
    }

    private function fetchTerms(): array
    {
        if (empty($this->getLimit())) {
            return [];
        }

        $args = [
            'taxonomy' => $this->getTaxonomies(),
            'hide_empty' => false,
            'fields' => 'all',
            'orderby' => 'count',
            'order' => 'DESC',
            'number' => $this->getLimit(),
        ];

        if ($this->randomize()) {
            $args['number'] = $this->getRandomizeLimit();
        }

        $terms = (new WP_Term_Query($args))->terms;
        if (!is_array($terms)) {
            return [];
        }

        return $terms;
    }

    protected function addTaxonomyControl(): void
    {
        $this->add_control(
            PopularTermsWidget::TAXONOMIES,
            [
                'label' => tdf_admin_string('taxonomies'),
                'type' => Controls_Manager::SELECT2,
                'options' => $this->getTaxonomyControlOptions(),
                'multiple' => true,
            ]
        );
    }

    private function getTaxonomyControlOptions(): array
    {
        $options = [];

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $options[$taxonomyField->getKey()] = $taxonomyField->getName();
        }

        return $options;
    }

    private function getTaxonomies(): array
    {
        $taxonomyKeys = $this->get_settings_for_display(PopularTermsWidget::TAXONOMIES);
        if (!is_array($taxonomyKeys) || empty($taxonomyKeys)) {
            return tdf_taxonomy_fields()->map(static function ($taxonomyField) {
                /* @var TaxonomyField $taxonomyField */
                return $taxonomyField->getKey();
            })->values();
        }

        return $taxonomyKeys;
    }

    protected function addRandomizeControls(): void
    {
        $this->add_control(
            PopularTermsWidget::RANDOMIZE,
            [
                'label' => tdf_admin_string('randomize'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            PopularTermsWidget::RANDOMIZE_LIMIT,
            [
                'label' => tdf_admin_string('randomize_limit'),
                'type' => Controls_Manager::NUMBER,
                'default' => PopularTermsWidget::RANDOMIZE_LIMIT_DEFAULT,
                'condition' => [
                    PopularTermsWidget::RANDOMIZE => '1',
                ]
            ]
        );
    }

    private function randomize(): bool
    {
        return !empty($this->get_settings_for_display(PopularTermsWidget::RANDOMIZE));
    }

    private function getRandomizeLimit(): int
    {
        $limit = $this->get_settings_for_display(PopularTermsWidget::RANDOMIZE_LIMIT);
        if (empty($limit)) {
            return PopularTermsWidget::RANDOMIZE_LIMIT_DEFAULT;
        }

        return $limit;
    }

}