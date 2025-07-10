<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\CurrentUserCan;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use WP_Term;

class TermFormServiceProvider extends ServiceProvider
{
    use CurrentUserCan;

    public function afterInitiation(): void
    {
        add_action('admin_init', function () {
            tdf_taxonomy_fields()->each(function ($taxonomyField) {
                /* @var TaxonomyField $taxonomyField */
                add_action($taxonomyField->getKey() . '_add_form_fields', function () use ($taxonomyField) {
                    if (!$this->currentUserCanManageOptions()) {
                        return;
                    }

                    global ${tdf_short_prefix() . 'TaxonomyField'};
                    ${tdf_short_prefix() . 'TaxonomyField'} = $taxonomyField;

                    tdf_load_view('term/create');
                });

                add_action($taxonomyField->getKey() . '_edit_form_fields', function (WP_Term $term) use ($taxonomyField) {
                    if (!$this->currentUserCanManageOptions()) {
                        return;
                    }

                    global ${tdf_short_prefix() . 'TaxonomyField'};
                    ${tdf_short_prefix() . 'TaxonomyField'} = $taxonomyField;

                    global ${tdf_short_prefix() . 'Term'};
                    ${tdf_short_prefix() . 'Term'} = tdf_term_factory()->create($term);

                    tdf_load_view('term/edit');
                });
            });
        });
    }
}