<?php


namespace Tangibledesign\Framework\Models\User\Helpers;


/**
 * Interface HasPhoneInterface
 * @package Tangibledesign\Framework\Models\User\Helpers
 */
interface HasPhoneInterface
{
    /**
     * @param string $phone
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setPhone($phone): bool;

    /**
     * @return string
     */
    public function getPhone(): string;
}