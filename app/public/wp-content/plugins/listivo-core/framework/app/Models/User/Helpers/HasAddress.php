<?php


namespace Tangibledesign\Framework\Models\User\Helpers;


use Tangibledesign\Framework\Models\Helpers\HasMeta;

/**
 * Trait HasAddress
 * @package Tangibledesign\Framework\Models\User\Helpers
 */
trait HasAddress
{
    use HasMeta;

    /**
     * @param string $address
     */
    public function setAddress($address): void
    {
        $this->setMeta(UserSettingKey::ADDRESS, (string)$address);
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return (string)$this->getMeta(UserSettingKey::ADDRESS);
    }

}