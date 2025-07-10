<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

class SaveFieldDependenciesServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action(tdf_prefix().'/fields/updated', [$this, 'save']);
    }

    public function save(Field $field): void
    {
        if (!isset($_POST[CustomTerm::FIELD_DEPENDENCIES]) || !$field instanceof TaxonomyField || !$field->fieldDependency()) {
            return;
        }

        foreach ($field->getMainTerms() as $term) {
            /* @var CustomTerm $term */
            if (isset($_POST[CustomTerm::FIELD_DEPENDENCIES][$term->getKey()])) {
                $term->setFieldDependencies($_POST[CustomTerm::FIELD_DEPENDENCIES][$term->getKey()]);
            } else {
                $term->setFieldDependencies();
            }
        }
    }

}