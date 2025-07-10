<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Term\CustomTerm;

class FieldDependencyServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['all_dependency_terms'] = static function () {
            $terms = tdf_collect();

            tdf_taxonomy_fields()->filter(static function ($taxonomyField) {
                /* @var TaxonomyField $taxonomyField */
                return $taxonomyField->fieldDependency();
            })->each(static function ($taxonomyField) use (&$terms) {
                /* @var TaxonomyField $taxonomyField */
                $terms = $terms->merge($taxonomyField->getTerms());
            });

            return $terms;
        };

        $this->container['dependency_terms'] = static function () {
            $terms = tdf_collect();

            tdf_taxonomy_fields()->filter(static function ($taxonomyField) {
                /* @var TaxonomyField $taxonomyField */
                return $taxonomyField->fieldDependency();
            })->each(static function ($taxonomyField) use (&$terms) {
                /* @var TaxonomyField $taxonomyField */
                $terms = $terms->merge($taxonomyField->getTermsWithFieldDependencies());
            });

            $hideTermIds = [];

            foreach (tdf_ordered_fields() as $field) {
                /* @var Field $field */
                $hideTermIds = [...$hideTermIds, ...$field->getHideTermIds()];
            }

            $hideTermIds = array_unique($hideTermIds);

            $hideTerms = [];

            foreach ($hideTermIds as $hideTermId) {
                $hideTerm = $terms->find(static function ($term) use ($hideTermId) {
                    /* @var CustomTerm $term */
                    return $term->getId() === $hideTermId;
                });

                if ($hideTerm) {
                    $hideTerms[] = $hideTerm;

                    continue;
                }

                $term = tdf_term_factory()->create($hideTermId);
                if ($term) {
                    $hideTerms[] = $term;
                }
            }

            return $terms->merge($hideTerms);
        };

        $this->container['main_dependency_terms'] = static function () {
            /** @noinspection NullPointerExceptionInspection */
            return tdf_app('dependency_terms')->filter(static function ($term) {
                /* @var CustomTerm $term */
                return $term->getMultiLevelParent() === 0;
            });
        };
    }
}