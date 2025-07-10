<?php


namespace Tangibledesign\Framework\Models\User\Helpers;


/**
 * Interface HasImageInterface
 * @package Tangibledesign\Framework\Models\User\Helpers
 */
interface HasImageInterface
{
    /**
     * @param int $imageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setImage($imageId): void;

    /**
     * @return int
     */
    public function getImageId(): int;
}