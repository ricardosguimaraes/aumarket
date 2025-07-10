<?php


namespace Tangibledesign\Framework\Validators;


use Tangibledesign\Framework\Core\BaseValidator;

/**
 * Class UserValidator
 * @package Tangibledesign\Framework\Validators
 */
class UserValidator extends BaseValidator
{
    /**
     * @return string[]
     */
    protected function getRules(): array
    {
        return [
            'name' => 'required|alpha',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'phone' => 'required',
        ];
    }

}