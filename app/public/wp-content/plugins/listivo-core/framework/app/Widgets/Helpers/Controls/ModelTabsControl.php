<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SortByControls;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

trait ModelTabsControl
{
    use Control;
    use LimitControl;
    use IncludeExcludedControl;
    use SortByControls;

    private $models;
    private $tabs;

    protected function addModelTabsControls(): void
    {
        $this->addFeaturedOnlyControl();

        $this->addLimitControl();

        $this->addIncludeExcludedControl();

        $this->addSortByControls(false);

        $this->addShowAllTabControls();

        $this->addTabsControl();
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

    protected function addShowAllTabControls(): void
    {
        $this->add_control(
            'show_all_tab_control',
            [
                'label' => tdf_admin_string('display_all_tab'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    protected function addTabsControl(): void
    {
        $tabs = new Repeater();

        $tabs->add_control(
            'taxonomy',
            [
                'label' => tdf_admin_string('taxonomy'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('taxonomy_list'),
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $tabs->add_control(
                'terms_' . $taxonomyField->getKey(),
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

        $this->add_control(
            'tabs',
            [
                'label' => tdf_admin_string('tabs'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $tabs->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    public function showAllTab(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_all_tab_control'));
    }

    /**
     * @return Collection|CustomTerm[]
     */
    public function getTabs(): Collection
    {
        if ($this->tabs === null) {
            $this->tabs = $this->fetchTabs();
        }

        return $this->tabs;
    }

    /**
     * @return Collection|CustomTerm[]
     */
    private function fetchTabs(): Collection
    {
        $terms = tdf_collect();
        $tabs = $this->get_settings_for_display('tabs');

        if (empty($tabs) || !is_array($tabs)) {
            return tdf_collect();
        }

        $tabs = tdf_collect($tabs)
            ->map(static function ($tab) {
                $taxonomyKey = $tab['taxonomy'];
                if (empty($taxonomyKey)) {
                    return false;
                }

                $termIds = $tab['terms_' . $taxonomyKey];
                if (empty($termIds)) {
                    return false;
                }

                return tdf_query_terms($taxonomyKey)
                    ->in($termIds)
                    ->get();
            })
            ->filter(static function ($terms) {
                return $terms !== false;
            });

        foreach ($tabs as $tab) {
            $terms = $terms->merge($tab);
        }

        return $terms;
    }

    /**
     * @return Collection|Model[]
     */
    private function fetchModels(): Collection
    {
        if ($this->showAllTab()) {
            return $this->fetchAllModels();
        }

        return $this->fetchModelsByFirstTab();
    }

    /**
     * @return Collection|Model[]
     */
    private function fetchAllModels(): Collection
    {
        $query = tdf_query_models()
            ->orderBy($this->getInitialSortBy())
            ->take($this->getLimit());

        if (!$this->includeExcluded()) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        if ($this->onlyFeatured()) {
            $query->featured();
        }

        return $query->get();
    }

    private function fetchModelsByFirstTab(): Collection
    {
        $tab = $this->getTabs()->first();
        if (!$tab instanceof CustomTerm) {
            return tdf_collect();
        }

        $query = tdf_query_models()
            ->orderBy($this->getInitialSortBy())
            ->byTerm($tab)
            ->take($this->getLimit());

        if (!$this->includeExcluded()) {
            $query->notIn(tdf_app('models_excluded_from_search'));
        }

        if ($this->onlyFeatured()) {
            $query->featured();
        }

        return $query->get();
    }

    /**
     * @return Collection|Model[]
     */
    public function getModels(): Collection
    {
        if ($this->models === null) {
            $this->models = $this->fetchModels();
        }

        return $this->models;
    }

    public function getInitialTab(): string
    {
        if ($this->showAllTab()) {
            return 'all';
        }

        $tab = $this->getTabs()->first();
        if (!$tab instanceof CustomTerm) {
            return '';
        }

        return (string)$tab->getId();
    }
}