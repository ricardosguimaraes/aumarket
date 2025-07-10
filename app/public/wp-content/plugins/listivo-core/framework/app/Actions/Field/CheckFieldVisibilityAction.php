<?php

namespace Tangibledesign\Framework\Actions\Field;

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Term\CustomTerm;

class CheckFieldVisibilityAction
{
    public function execute(int $fieldId): array
    {
        $field = tdf_ordered_fields()->find(function ($field) use ($fieldId) {
            return $field->getId() === $fieldId;
        });

        if (!$field instanceof Field) {
            return [];
        }

        return [
            'field_name' => $field->getName(),
            'terms_can_hide_field' => $this->getTermWhichCanHideField($field),
            'terms_must_be_selected' => $this->getTermWhichMustBeSelected($field),
        ];
    }

    private function getTermWhichCanHideField(Field $field): array
    {
        $terms = [];
        foreach ($field->getHideTermIds() as $termId) {
            $term = tdf_term_factory()->create($termId);
            if ($term) {
                $terms[] = $term;
            }
        }

        return $terms;
    }

    private function getTermWhichMustBeSelected(Field $field): array
    {
        $terms = [];

        foreach (tdf_app('dependency_terms') as $term) {
            /* @var CustomTerm $term */
            if (in_array($field->getId(), $term->getFieldDependencies(), true)) {
                $terms[] = $term;
            }
        }

        return $terms;
    }
}