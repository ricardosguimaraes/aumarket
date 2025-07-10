<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

/**
 * Class RegisterTaxonomyFieldsServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class RegisterTaxonomyFieldsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_filter('tdf/taxonomies', static function (array $data) {
            return array_merge($data, tdf_taxonomy_fields()->map(static function ($taxonomyField) {
                /* @var TaxonomyField $taxonomyField */
                return [
                    'key' => $taxonomyField->getKey(),
                    'object_type' => tdf_prefix().'_listing',
                    'label' => $taxonomyField->getName(),
                    'settings' => [
                        'hierarchical' => $taxonomyField->isMultilevel(),
                        'rewrite' => [
                            'slug' => $taxonomyField->getSlug(),
                            'with_front' => true,
                            'hierarchical' => false,
                            'ep_mask' => EP_NONE
                        ],
                        'show_in_rest' => true,
                        'rest_base' => $taxonomyField->getKey(),
                        'show_in_quick_edit' => false,
                        'meta_box_cb' => false,
                    ]
                ];
            })->values());
        });
    }

}