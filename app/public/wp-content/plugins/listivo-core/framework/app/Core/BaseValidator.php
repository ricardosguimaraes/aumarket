<?php


namespace Tangibledesign\Framework\Core;


use Rakit\Validation\Validator;

/**
 * Class BaseValidator
 * @package Tangibledesign\Framework\Core
 */
abstract class BaseValidator
{
    /**
     * @param  array  $data
     * @return bool
     */
    public function validate(array $data): bool
    {
        return (new Validator())->make($data, $this->getRules())->passes();
    }

    /**
     * @return array
     */
    abstract protected function getRules(): array;

}