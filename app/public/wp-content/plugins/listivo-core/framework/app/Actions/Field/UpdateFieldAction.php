<?php


namespace Tangibledesign\Framework\Actions\Field;


use Tangibledesign\Framework\Validators\FieldValidator;

/**
 * Class UpdateFieldAction
 * @package Tangibledesign\Framework\Actions\Field
 */
class UpdateFieldAction
{
    /**
     * @param  array  $data
     * @return bool
     */
    public function update(array $data): bool
    {
        if (!(new FieldValidator())->validate($data)) {
            return false;
        }

        $field = tdf_field_factory()->create((int)$data['id']);
        if (!$field) {
            return false;
        }

        $field->updateSettings($data);

        do_action(tdf_prefix().'/fields/updated', $field);

        return true;
    }

}