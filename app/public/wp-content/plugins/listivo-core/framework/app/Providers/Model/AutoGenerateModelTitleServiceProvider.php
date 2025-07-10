<?php

namespace Tangibledesign\Framework\Providers\Model;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Term\CustomTerm;

class AutoGenerateModelTitleServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_filter(tdf_prefix() . '/model/name', [$this, 'generateTitle'], 10, 2);
        add_action(tdf_prefix() . '/model/update', [$this, 'save']);
    }

    public function save(Model $model): void
    {
        if (
            tdf_settings()->getAutoGenerateModelTitleFieldIds()->isEmpty()
            || tdf_settings()->getAutoGenerateModelTitleFields()->isEmpty()
        ) {
            return;
        }

        $parts = [];

        foreach (tdf_settings()->getAutoGenerateModelTitleFields() as $taxonomyField) {
            /* @var TaxonomyField $taxonomyField */
            foreach ($taxonomyField->getValue($model) as $term) {
                /* @var CustomTerm $term */
                if ($term instanceof CustomTerm) {
                    $parts[] = $term->getSlug();
                }
            }
        }

        $parts[] = $model->getId();

        wp_update_post([
            'ID' => $model->getId(),
            'post_title' => $model->getName(),
            'post_name' => implode('-', $parts),
        ], false, false);
    }

    public function generateTitle($name, $model): string
    {
        $fields = tdf_settings()->getAutoGenerateModelTitleFields();
        if ($fields->isEmpty()) {
            return $name;
        }

        $values = tdf_collect();

        foreach ($fields as $field) {
            /* @var SimpleTextValue $field */
            $values = $values->merge($field->getSimpleTextValue($model));
        }

        return $values->implode(' ');
    }
}