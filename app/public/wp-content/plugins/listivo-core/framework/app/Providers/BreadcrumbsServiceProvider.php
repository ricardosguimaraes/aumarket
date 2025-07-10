<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

class BreadcrumbsServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['breadcrumbs_taxonomies'] = static function () {
            return tdf_collect(tdf_settings()->getBreadcrumbs())
                ->map(static function ($taxonomyKey) {
                    return tdf_taxonomy_fields()->find(static function ($taxonomyField) use ($taxonomyKey) {
                        /* @var TaxonomyField $taxonomyField */
                        return $taxonomyField->getKey() === $taxonomyKey;
                    });
                })->filter(static function ($taxonomyField) {
                    return $taxonomyField !== false && $taxonomyField !== null;
                });
        };
    }

}