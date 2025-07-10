<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackage;

class TaxonomyPanelField extends CustomPanelField
{
    /**
     * @var TaxonomyField
     */
    protected $field;

    protected ?Collection $terms = null;

    protected function getTemplate(): string
    {
        return 'taxonomy';
    }

    public function disableLazyLoading(): bool
    {
        return !empty($this->field->getFrontendPanelOptionIds());
    }

    public function getTerms(): Collection
    {
        if ($this->terms) {
            return $this->terms;
        }

        if (function_exists('customtaxorder_sort_taxonomies')) {
            return tdf_query_terms($this->field->getKey())
                ->orderBy3rdPartyPlugin()
                ->get();
        }

        $terms = $this->field->getFrontendPanelOptions();
        if ($terms->isEmpty()) {
            $terms = $this->field->getMainTerms();
        }

        $this->terms = apply_filters(tdf_prefix() . '/panel/field/' . $this->field->getId() . '/terms', $terms);

        return $this->terms;
    }

    public function update(Model $model, array $data = []): void
    {
        wp_set_object_terms($model->getId(), $this->getValue($data), $this->getKey());
    }

    private function getValue(array $data): array
    {
        $attributeData = $this->getAttributeData($data);

        if (!$attributeData || !isset($attributeData['value']) || !is_array($attributeData['value'])) {
            return [];
        }

        return Collection::make($attributeData['value'])->map(static function ($term) {
            return (int)$term['id'];
        })->values();
    }

    public function isSingleValue(): bool
    {
        return !$this->field->multipleValues();
    }

    public function loadTemplate(): void
    {
        if ($this->isSingleValue()) {
            parent::loadTemplate();

            return;
        }

        global ${tdf_short_prefix() . 'PanelField'};
        ${tdf_short_prefix() . 'PanelField'} = $this;

        if ($this->field->isMultilevel()) {
            get_template_part('templates/widgets/general/panel/fields/taxonomy_multilevel');

            return;
        }

        get_template_part('templates/widgets/general/panel/fields/taxonomy_multiple');
    }

    public function validate(array $data): bool
    {
        if (!$this->isRequired()) {
            return true;
        }

        $attribute = $this->getAttributeData($data);

        return !(
            !$attribute
            || empty($attribute['value'])
            || !is_array($attribute['value'])
        );
    }

    public function getModelAttribute(Model $model): array
    {
        return [
            'id' => $this->field->getId(),
            'value' => json_decode(json_encode($this->field->getValue($model)), true),
        ];
    }

    public function getAllowedTermIds(?RegularUserPaymentPackage $package): array
    {
        if (!$package) {
            return [];
        }

        if (tdf_settings()->getMainCategoryId() !== $this->field->getId()) {
            return [];
        }

        if ($package->isGeneral()) {
            return [];
        }

        $categoryIds = $package->getCategoryIds();
        if (empty($categoryIds)) {
            return [];
        }

        return [...$categoryIds, ...$this->getAllChildrenIds($this->field->getKey(), $categoryIds)];
    }

    private function getAllChildrenIds(string $taxonomyKey, array $parentIds): array
    {
        $args = [
            'taxonomy' => $taxonomyKey,
            'hide_empty' => false,
            'parent' => implode(',', $parentIds),
        ];

        $terms = get_terms($args);
        $childrenIds = [];

        foreach ($terms as $term) {
            $childrenIds[] = $term->term_id;

            $children = $this->getAllChildrenIds($taxonomyKey, [$term->term_id]);
            $childrenIds = [...$childrenIds, ...$children];
        }

        return $childrenIds;
    }
}