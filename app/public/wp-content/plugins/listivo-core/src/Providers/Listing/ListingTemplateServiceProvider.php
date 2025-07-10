<?php

namespace Tangibledesign\Listivo\Providers\Listing;

use Tangibledesign\Framework\Core\ServiceProvider;


class ListingTemplateServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_filter('listivo/template/current', [$this, 'template']);
    }

    /** @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    public function template($template)
    {
        if (!empty($_GET['print']) || !is_singular(tdf_model_post_type())) {
            return $template;
        }

        global $lstModel;
        if (!$lstModel) {
            return $template;
        }

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            foreach ($taxonomyField->getValue($lstModel) as $term) {
                $termTemplate = $term->getCustomTemplate();
                if ($termTemplate) {
                    return $termTemplate;
                }
            }
        }

        return $template;
    }

}