<?php

namespace Tangibledesign\Framework\Actions\Panel;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\PanelFields\CustomPanelField;
use Tangibledesign\Framework\Models\PanelFields\DescriptionPanelField;
use Tangibledesign\Framework\Models\PanelFields\NamePanelField;
use Tangibledesign\Framework\Models\PanelFields\PanelField;

class GetModelFormFieldsAction
{

    public function execute(): Collection
    {
        $defaultFields = tdf_collect([
            new NamePanelField(),
            new DescriptionPanelField(),
        ]);

        return $defaultFields
            ->merge($this->getCustomFields())
            ->filter(static function ($panelField) {
                /* @var PanelField $panelField */
                return $panelField->visibleByUserRole(tdf_app('current_user_role'));
            });
    }

    /**
     * @return Collection|PanelField[]
     */
    private function getCustomFields(): Collection
    {
        $customFields = tdf_collect();

        foreach (tdf_ordered_fields() as $field) {
            if ($field instanceof LocationField && empty(tdf_settings()->getGoogleMapsApiKey())) {
                continue;
            }

            $customFields[] = CustomPanelField::create($field);
        }

        return $customFields;
    }

}