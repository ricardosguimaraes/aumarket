<?php


namespace Tangibledesign\Framework\Validators;


use Tangibledesign\Framework\Core\BaseValidator;

/**
 * Class CurrencyValidator
 * @package Tangibledesign\Framework\Validators
 */
class CurrencyValidator extends BaseValidator
{
    /**
     * @return string[]
     */
    protected function getRules(): array
    {
        return [
            'id' => 'integer',
            'name' => 'required',
            'sign' => 'required',
            'signPosition' => 'required|in:before,after',
            'format' => 'required',
        ];
    }

}