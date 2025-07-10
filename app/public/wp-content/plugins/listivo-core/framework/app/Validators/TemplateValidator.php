<?php


namespace Tangibledesign\Framework\Validators;


use Tangibledesign\Framework\Core\BaseValidator;

/**
 * Class TemplateValidator
 * @package Tangibledesign\Framework\Validators
 */
class TemplateValidator extends BaseValidator
{
    /**
     * @return string[]
     */
    protected function getRules(): array
    {
        return [
            'id' => 'integer|required',
            'name' => 'alpha|required',
            'type' => 'alpha|required',
        ];
    }

}