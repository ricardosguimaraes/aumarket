<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

trait TermListWithImagesControl
{
    use Control;

    private function addTermsControl(bool $multiple = false): void
    {
        $this->add_control(
            'taxonomy',
            [
                'label' => tdf_admin_string('taxonomy'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('taxonomy_list'),
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomy) {
            $this->addTermsControlByTaxonomy($taxonomy, $multiple);
        }
    }

    private function addTermsControlByTaxonomy(TaxonomyField $taxonomyField, bool $multiple = false): void
    {
        $terms = new Repeater();

        $terms->add_control(
            'termId',
            [
                'label' => tdf_admin_string('term'),
                'type' => SelectRemoteControl::TYPE,
                'source' => $taxonomyField->getApiEndpoint(),
                'multiple' => $multiple,

            ]
        );

        $terms->add_control(
            'image',
            [
                'label' => tdf_admin_string('image'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_control(
            'terms_' . $taxonomyField->getKey(),
            [
                'label' => tdf_admin_string('terms'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $terms->get_controls(),
                'prevent_empty' => false,
                'condition' => [
                    'taxonomy' => $taxonomyField->getKey(),
                ]
            ]
        );
    }

    public function getTerms(): Collection
    {
        $taxonomyField = $this->getTaxonomyField();
        if (!$taxonomyField) {
            return tdf_collect();
        }

        $termsData = $this->get_settings_for_display('terms_' . $taxonomyField->getKey());
        if (empty($termsData) || !is_array($termsData)) {
            return tdf_collect();
        }

        return tdf_collect($termsData)
            ->map(static function ($termData) {
                $term = tdf_term_factory()->create((int)$termData['termId']);
                if (!$term instanceof CustomTerm) {
                    return false;
                }

                $termData['term'] = $term;

                return $termData;
            })
            ->filter(static function ($termData) {
                return $termData !== false;
            });
    }

    private function getTaxonomyField(): ?TaxonomyField
    {

        $taxonomyKey = $this->get_settings_for_display('taxonomy');
        if (empty($taxonomyKey)) {
            return null;
        }

        $taxonomyField = tdf_taxonomy_fields()->find(static function ($taxonomy) use ($taxonomyKey) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getKey() === $taxonomyKey;
        });

        if (!$taxonomyField instanceof TaxonomyField) {
            return null;
        }

        return $taxonomyField;
    }
}