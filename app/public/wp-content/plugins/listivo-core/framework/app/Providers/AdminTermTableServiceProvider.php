<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

/**
 * Class AdminTermTableServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class AdminTermTableServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function afterInitiation(): void
    {
        add_action('admin_init', static function () {
            foreach (tdf_taxonomy_fields() as $taxonomyField) {
                /* @var TaxonomyField $taxonomyField */
                $parentTaxonomyFields = $taxonomyField->getParentTaxonomyFields();
                if ($parentTaxonomyFields->isEmpty()) {
                    continue;
                }

                add_filter('manage_edit-'.$taxonomyField->getKey().'_columns',
                    static function () use ($parentTaxonomyFields) {
                        $column = [
                            'cb' => '<input type="checkbox" />',
                            'name' => tdf_admin_string('name'),
                        ];

                        foreach ($parentTaxonomyFields as $parentTaxonomyField) {
                            /* @var TaxonomyField $parentTaxonomyField */
                            $column[$parentTaxonomyField->getKey()] = $parentTaxonomyField->getName();
                        }

                        $column['description'] = tdf_admin_string('description');
                        $column['slug'] = tdf_admin_string('slug');
                        $column['posts'] = tdf_admin_string('count');

                        return $column;
                    });

                foreach ($parentTaxonomyFields as $parentTaxonomyField) {
                    add_filter('manage_'.$taxonomyField->getKey().'_custom_column',
                        static function ($content, $columnName, $termId) use ($parentTaxonomyField) {
                            if ($columnName !== $parentTaxonomyField->getKey()) {
                                return $content;
                            }

                            $term = tdf_term_factory()->create($termId);
                            if (!$term instanceof CustomTerm) {
                                return $content;
                            }

                            $parentTerms = $term->getParentTerms();
                            if ($parentTerms->isEmpty()) {
                                return tdf_admin_string('not_set');
                            }

                            $parentTerms = $parentTerms->filter(static function ($parentTerm) use ($parentTaxonomyField
                            ) {
                                /* @var CustomTerm $parentTerm */
                                return $parentTerm->getTaxonomyKey() === $parentTaxonomyField->getKey();
                            });

                            if ($parentTerms->isEmpty()) {
                                return tdf_admin_string('not_set');
                            }

                            return $parentTerms->map(static function ($parentTerm) {
                                /* @var CustomTerm $parentTerm */
                                return $parentTerm->getName();
                            })->implode();
                        }, 10, 3);
                }
            }
        });
    }

}