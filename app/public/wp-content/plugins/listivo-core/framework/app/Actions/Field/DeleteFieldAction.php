<?php


namespace Tangibledesign\Framework\Actions\Field;


/**
 * Class DeleteFieldAction
 * @package Tangibledesign\Framework\Actions\Field
 */
class DeleteFieldAction
{
    /**
     * @param int $fieldId
     */
    public function delete(int $fieldId): void
    {
        wp_delete_post($fieldId);
    }

}