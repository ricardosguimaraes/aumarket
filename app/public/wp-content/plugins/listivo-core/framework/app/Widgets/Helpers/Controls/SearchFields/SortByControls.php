<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Search\Sortable;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait SortByControls
{
    use Control;

    protected function addSortByControls(bool $searchResults = true): void
    {
        $options = $searchResults ? tdf_app('sort_by_options') : tdf_app('sort_by_options_with_random');

        $this->add_control(
            'sort_by_initial',
            [
                'label' => tdf_admin_string('initial_sort_by'),
                'type' => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => $options
            ]
        );

        if (!$searchResults) {
            return;
        }

        $this->add_control(
            'show_sort_by',
            [
                'label' => tdf_admin_string('show_sort_by_control'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1'
            ]
        );

        $fields = new Repeater();

        $fields->add_control(
            'type',
            [
                'label' => tdf_admin_string('type'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => 'newest'
            ]
        );

        $fields->add_control(
            'label',
            [
                'label' => tdf_admin_string('custom_label'),
                'type' => Controls_Manager::TEXT
            ]
        );

        $this->add_control(
            'sort_by_options',
            [
                'type' => Controls_Manager::REPEATER,
                'label' => tdf_admin_string('sort_by'),
                'fields' => $fields->get_controls(),
                'condition' => [
                    'show_sort_by' => '1'
                ],
                'default' => tdf_app('sort_by_default_options'),
            ]
        );
    }

    public function showSortBy(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_sort_by'));
    }

    public function getInitialSortBy(): string
    {
        return $_GET[tdf_slug('sort-by')] ?? $this->getDefaultSortBy();
    }

    protected function getDefaultSortBy(): string
    {
        $sortBy = $this->get_settings_for_display('sort_by_initial');
        if (empty($sortBy)) {
            return tdf_slug('newest');
        }

        return $this->getSlug($sortBy);
    }

    protected function getSlug(string $sortBy): string
    {
        if ($sortBy === 'newest') {
            return tdf_slug('newest');
        }

        if ($sortBy === 'oldest') {
            return tdf_slug('oldest');
        }

        if ($sortBy === 'most_relevant') {
            return tdf_slug('most_relevant');
        }

        if ($sortBy === 'name_asc') {
            return tdf_slug('name_asc');
        }

        if ($sortBy === 'random') {
            return 'random';
        }

        foreach (tdf_fields()->filter(static function ($field) {
            return $field instanceof Sortable;
        }) as $field) {
            if ($sortBy === $field->getKey().'-high_to_low') {
                return $field->getSlug().'-'.tdf_slug('high_to_low');
            }

            if ($sortBy === $field->getKey().'-low_to_high') {
                return $field->getSlug().'-'.tdf_slug('low_to_high');
            }
        }

        return tdf_slug('newest');
    }

    public function getSortByOptions(): array
    {
        $selectedSortByOptions = $this->get_settings_for_display('sort_by_options');
        if (!is_array($selectedSortByOptions)) {
            return [];
        }

        $sortByOptions = tdf_collect(tdf_app('sort_by_options'))
            ->map(static function ($sortByName, $sortByKey) {
                foreach (tdf_app('sortable_fields') as $field) {
                    /* @var Field $field */
                    if ($sortByKey === $field->getKey().'-high_to_low' || $sortByKey === $field->getKey().'-low_to_high') {
                        return [
                            'id' => $sortByKey,
                            'name' => $sortByName,
                            'field' => [
                                'id' => $field->getId(),
                                'hideTerms' => $field->getHideTermIds(),
                            ],
                        ];
                    }
                }

                return [
                    'id' => $sortByKey,
                    'name' => $sortByName,
                    'field' => false,
                ];
            });

        return tdf_collect($selectedSortByOptions)
            ->map(function ($sortByOption) use ($sortByOptions) {
                $sortByKey = $sortByOption['type'];

                $option = $sortByOptions->find(static function ($sortByOpt) use ($sortByKey) {
                    return $sortByOpt['id'] === $sortByKey;
                });

                if (!$option) {
                    return false;
                }

                $option['id'] = $this->getSlug($option['id']);

                if (!empty($sortByOption['label'])) {
                    $option['name'] = $sortByOption['label'];
                }

                return $option;
            })->filter(static function ($sortByOption) {
                return $sortByOption !== false;
            })->values();
    }
}