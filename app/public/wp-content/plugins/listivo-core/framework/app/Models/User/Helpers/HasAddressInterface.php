<?php


namespace Tangibledesign\Framework\Models\User\Helpers;


/**
 * Interface HasAddressInterface
 * @package Tangibledesign\Framework\Models\User\Helpers
 */
interface HasAddressInterface
{
    /**
     * @param string $address
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setAddress($address): void;

    /**
     * @return string
     */
    public function getAddress(): string;
}