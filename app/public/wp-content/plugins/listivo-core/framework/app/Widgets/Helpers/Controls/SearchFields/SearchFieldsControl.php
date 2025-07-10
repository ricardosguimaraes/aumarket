<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Search\Field\KeywordSearchField;
use Tangibledesign\Framework\Search\Field\NumberSearchField;
use Tangibledesign\Framework\Search\Field\PriceSearchField;
use Tangibledesign\Framework\Search\Field\SalarySearchField;
use Tangibledesign\Framework\Search\Searchable;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Search\SearchModels;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

trait SearchFieldsControl
{
    use Control;
    use TaxonomySearchFieldControls;
    use NumberSearchFieldControls;
    use PriceSearchFieldControls;
    use TextSearchFieldControls;
    use LocationSearchFieldControls;
    use KeywordSearchFieldControls;

    protected function addSearchFieldsControls(Repeater $fields): void
    {
        $fields->add_control(
            'icon',
            [
                'label' => tdf_admin_string('icon'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $fields->add_control(
            'field',
            [
                'label' => tdf_admin_string('field'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getFieldOptions(),
            ]
        );

        $this->addTaxonomyFieldSettings($fields);

        $this->addNumberFieldSettings($fields);

        $this->addPriceFieldSettings($fields);

        $this->addTextFieldSettings($fields);

        $this->addLocationFieldSettings($fields);

        $this->addKeywordFieldSettings($fields);
    }

    protected function getFieldOptions(): array
    {
        $options = [
            'keyword' => tdf_admin_string('keyword'),
        ];

        foreach (tdf_ordered_fields() as $field) {
            if ($field instanceof Searchable) {
                $options[$field->getKey()] = $field->getName();
            }
        }

        return $options;
    }

    /**
     * @param string $optionKey
     * @return Collection|SearchField[]
     */
    protected function getSearchFields(string $optionKey): Collection
    {
        $fields = $this->get_settings_for_display($optionKey);

        if (!is_array($fields) || empty($fields)) {
            return tdf_collect();
        }

        return tdf_collect($fields)->map(function ($fieldData) {
            if ($fieldData['field'] === 'keyword') {
                return new KeywordSearchField($fieldData);
            }

            $field = $this->getField($fieldData['field']);
            if (!$field) {
                return false;
            }

            return $field->getSearchField($fieldData);
        })->filter(static function ($searchField) {
            return $searchField instanceof SearchField;
        });
    }

    /**
     * @param string $key
     * @return Searchable|false
     */
    private function getField(string $key)
    {
        return tdf_fields()->find(static function ($field) use ($key) {
            return $field instanceof Searchable && $field->getKey() === $key;
        });
    }

    protected function addMainFieldControls(bool $images = false): void
    {
        $this->add_control(
            'main_field_taxonomy',
            [
                'label' => tdf_admin_string('taxonomy'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('taxonomy_list'),
            ]
        );

        $this->add_control(
            'main_field_all',
            [
                'label' => tdf_admin_string('all_option'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        if ($images) {
            $this->add_control(
                'main_field_all_image',
                [
                    'label' => tdf_admin_string('all_tab_image'),
                    'type' => Controls_Manager::MEDIA,
                    'condition' => [
                        'main_field_all' => '1',
                    ]
                ]
            );
        }

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $terms = new Repeater();

            if ($images) {
                $terms->add_control(
                    'image',
                    [
                        'label' => tdf_admin_string('image'),
                        'type' => Controls_Manager::MEDIA,
                    ]
                );
            }


            $terms->add_control(
                'term',
                [
                    'label' => tdf_admin_string('term'),
                    'type' => SelectRemoteControl::TYPE,
                    'source' => $taxonomyField->getApiEndpoint(),
                ]
            );

            $this->add_control(
                'main_field_terms_' . $taxonomyField->getKey(),
                [
                    'label' => tdf_admin_string('terms'),
                    'type' => Controls_Manager::REPEATER,
                    'fields' => $terms->get_controls(),
                    'prevent_empty' => false,
                    'condition' => [
                        'main_field_taxonomy' => $taxonomyField->getKey(),
                    ]
                ]
            );
        }
    }

    public function hasMainFieldAllOption(): bool
    {
        return !empty($this->get_settings_for_display('main_field_all'));
    }

    public function getMainFieldAllImage(): string
    {
        $image = $this->get_settings_for_display('main_field_all_image');

        return $image['url'] ?? '';
    }

    /**
     * @param Collection $termsData
     * @return Collection|CustomTerm[]
     */
    public function getMainFieldTerms(Collection $termsData): Collection
    {
        return $termsData->map(static function ($termData) {
            return $termData['term'];
        });
    }

    public function getMainFieldTermsData(): Collection
    {
        $taxonomyKey = $this->get_settings_for_display('main_field_taxonomy');
        if (empty($taxonomyKey)) {
            return tdf_collect();
        }

        $taxonomyField = tdf_taxonomy_fields()->find(static function ($taxonomy) use ($taxonomyKey) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getKey() === $taxonomyKey;
        });

        if (!$taxonomyField instanceof TaxonomyField) {
            return tdf_collect();
        }

        $termsData = $this->get_settings_for_display('main_field_terms_' . $taxonomyKey);
        if (empty($termsData)) {
            return tdf_collect();
        }

        return tdf_collect($termsData)
            ->map(static function ($termData) {
                return [
                    'term' => tdf_term_factory()->create((int)$termData['term']),
                    'image' => $termData['image'] ?? false,
                ];
            })
            ->filter(static function ($termData) {
                return $termData['term'] instanceof CustomTerm;
            });
    }

    /**
     * @return TaxonomyField|false
     */
    public function getMainFieldTaxonomy()
    {
        $taxonomyKey = $this->get_settings_for_display('main_field_taxonomy');
        if (empty($taxonomyKey)) {
            return false;
        }

        return tdf_taxonomy_fields()->find(static function ($taxonomy) use ($taxonomyKey) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getKey() === $taxonomyKey;
        });
    }

    /**
     * @return Collection|SearchField[]
     */
    public function getFields(): Collection
    {
        return $this->getSearchFields('fields');
    }

	public function getTermCount(array $params = []): array
	{
		if (!isset($params['filters'])) {
			return (new SearchModels($params))->getTermsCount();
		}

		return (new SearchModels($params))
			->getTermsCount($params['filters']);
	}

	public function getInitialFilters(CustomTerm $term): array
	{
		return [
			[
				'key' => $term->getTaxonomyKey(),
				'values' => [$term->getId()],
				'type' => 'taxonomy',
			]
		];
	}
}