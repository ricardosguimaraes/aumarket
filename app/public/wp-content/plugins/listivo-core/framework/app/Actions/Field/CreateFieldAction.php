<?php


namespace Tangibledesign\Framework\Actions\Field;


use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Validators\FieldValidator;

/**
 * Class CreateFieldAction
 * @package Tangibledesign\Framework\Actions\Field
 */
class CreateFieldAction
{
    /**
     * @param  array  $data
     * @return false|Field
     */
    public function create(array $data)
    {
        if (!(new FieldValidator())->validate($data)) {
            return false;
        }

        $fieldId = wp_insert_post([
            'post_title' => $data['name'],
            'post_type' => tdf_prefix().'_field',
            'post_status' => PostStatus::PUBLISH,
        ]);

        if (is_wp_error($fieldId)) {
            return false;
        }

        update_post_meta($fieldId, Field::TYPE, $data['type']);

        return tdf_field_factory()->create($fieldId);
    }

}