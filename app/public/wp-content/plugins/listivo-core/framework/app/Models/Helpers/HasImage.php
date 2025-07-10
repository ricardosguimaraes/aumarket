<?php


namespace Tangibledesign\Framework\Models\Helpers;


/**
 * Trait HasImage
 * @package Tangibledesign\Framework\Models\Helpers
 */
trait HasImage
{
    use HasMeta;

    /**
     * @param int $imageId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setImage($imageId): void
    {
        $this->setMeta('image', $imageId);
    }

    /**
     * @return int
     */
    public function getImageId(): int
    {
        return (int)$this->getMeta('image');
    }

}