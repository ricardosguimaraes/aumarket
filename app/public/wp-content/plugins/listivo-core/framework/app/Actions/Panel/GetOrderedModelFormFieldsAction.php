<?php

namespace Tangibledesign\Framework\Actions\Panel;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\PanelFields\CustomPanelField;
use Tangibledesign\Framework\Models\PanelFields\DescriptionPanelField;
use Tangibledesign\Framework\Models\PanelFields\LocationPanelField;
use Tangibledesign\Framework\Models\PanelFields\NamePanelField;
use Tangibledesign\Framework\Models\PanelFields\PanelField;

class GetOrderedModelFormFieldsAction
{

    public function execute(array $fieldsData): Collection
    {
        if (empty($fieldsData)) {
            return tdf_collect();
        }

        return tdf_collect($fieldsData)
            ->map(static function ($field) {
                return $field['field'] ?? '';
            })
            ->map(static function ($fieldKey) {
                if (empty($fieldKey)) {
                    return null;
                }

                if ($fieldKey === 'name') {
                    return new NamePanelField();
                }

                if ($fieldKey === 'description') {
                    return new DescriptionPanelField();
                }

                $field = tdf_ordered_fields()->find(static function ($field) use ($fieldKey) {
                    /* @var Field $field */
                    return $field->getKey() === $fieldKey;
                });

                if (!$field instanceof Field) {
                    return null;
                }

                return CustomPanelField::create($field);
            })->filter(static function ($panelField) {
                if (!$panelField instanceof PanelField) {
                    return false;
                }

                if ($panelField instanceof LocationPanelField && empty(tdf_settings()->getGoogleMapsApiKey())) {
                    return false;
                }

                return $panelField->visibleByUserRole(tdf_app('current_user_role'));
            });
    }

}