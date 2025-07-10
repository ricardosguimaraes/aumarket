<?php


namespace Tangibledesign\Framework\Validators;


use Tangibledesign\Framework\Core\BaseValidator;

/**
 * Class FieldValidator
 * @package Tangibledesign\Framework\Validators
 */
class FieldValidator extends BaseValidator
{
    /**
     * @return string[]
     */
    protected function getRules(): array
    {
        return [
            'id' => 'integer',
            'name' => 'required',
            'type' => 'required',
        ];
    }

}