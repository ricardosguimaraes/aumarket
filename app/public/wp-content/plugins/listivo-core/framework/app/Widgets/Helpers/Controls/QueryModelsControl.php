<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Queries\QueryModels;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

trait QueryModelsControl
{
    use Control;
    use IncludeExcludedControl;
    use LimitControl;

    protected function addQueryModelsControls(): void
    {
        $this->addLimitControl();

        $this->addTermsControl();

        $this->addFeaturedOnlyControl();

        $this->addIncludeExcludedControl();
    }

    public function getListings(): Collection
    {
        $query = tdf_query_models()
            ->take($this->getLimit());

        if (!$this->includeExcluded()) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        $this->filterByTerms($query);

        if ($this->onlyFeatured()) {
            $query->featured();
        }

        $query->orderBy($this->getOrderBy());

        return $query->get();
    }

    public function getOrderBy(): string
    {
        $orderBy = $this->getInitialSortBy();
        if (empty($orderBy)) {
            return tdf_slug('newest');
        }

        return $orderBy;
    }

    protected function addTermsControl(): void
    {
        $this->add_control(
            'taxonomy',
            [
                'label' => tdf_admin_string('taxonomy'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getTaxonomyControlOptions(),
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $this->add_control(
                'taxonomy_' . $taxonomyField->getKey(),
                [
                    'label' => tdf_admin_string('terms'),
                    'type' => SelectRemoteControl::TYPE,
                    'source' => $taxonomyField->getApiEndpoint(),
                    'multiple' => true,
                    'condition' => [
                        'taxonomy' => $taxonomyField->getKey(),
                    ]
                ]
            );
        }
    }

    private function getTaxonomyControlOptions(): array
    {
        $options = [];

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $options[$taxonomyField->getKey()] = $taxonomyField->getName();
        }

        return $options;
    }

    private function filterByTerms(QueryModels $queryModels): QueryModels
    {
        $taxonomyKey = $this->get_settings_for_display('taxonomy');
        if (empty($taxonomyKey)) {
            return $queryModels;
        }

        $terms = $this->get_settings_for_display('taxonomy_' . $taxonomyKey);
        if (empty($terms) || !is_array($terms)) {
            return $queryModels;
        }

        $queryModels->setTaxQuery([
            [
                'taxonomy' => $taxonomyKey,
                'field' => 'id',
                'terms' => $terms,
            ]
        ]);

        return $queryModels;
    }

    protected function addFeaturedOnlyControl(): void
    {
        $this->add_control(
            'only_featured',
            [
                'label' => tdf_admin_string('only_featured'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function onlyFeatured(): bool
    {
        return !empty($this->get_settings_for_display('only_featured'));
    }
}