<?php

namespace Tangibledesign\Framework\Models\User\Helpers;

use Tangibledesign\Framework\Models\Helpers\HasMeta;
use Tangibledesign\Framework\Models\Image;

trait HasImage
{
    use HasMeta;

    public function setImage($imageId): void
    {
        $this->setMeta(UserSettingKey::IMAGE, (int)$imageId);
    }

    public function getImageId(): int
    {
        return (int)$this->getMeta(UserSettingKey::IMAGE);
    }

    /**
     * @return Image|false
     */
    public function getImage()
    {
        $imageId = $this->getImageId();
        if (empty($imageId)) {
            return false;
        }

        $image = tdf_post_factory()->create($imageId);
        if (!$image instanceof Image) {
            return false;
        }

        return $image;
    }

    public function hasImageUrl(string $size = 'full'): bool
    {
        if ($this->hasSocialImage()) {
            return true;
        }

        $image = $this->getImage();
        if (!$image) {
            return false;
        }

        return $image->getImageUrl($size) !== '';
    }

    public function getImageUrl(string $size = 'full'): string
    {
        if ($this->hasSocialImage()) {
            return $this->getSocialImage();
        }

        $image = $this->getImage();
        if (!$image) {
            return '';
        }

        return $image->getImageUrl($size);
    }

    public function setSocialImage(string $image): void
    {
        $this->setMeta(UserSettingKey::SOCIAL_IMAGE, $image);
    }

    public function getSocialImage(): string
    {
        return (string)$this->getMeta(UserSettingKey::SOCIAL_IMAGE);
    }

    public function hasSocialImage(): bool
    {
        return !empty($this->getSocialImage());
    }

    public function isFacebookImage(): bool
    {
        return apply_filters(
            tdf_prefix() . '/user/image/isFacebook',
            strpos($this->getSocialImage(), 'facebook') !== false,
            $this
        );
    }

    public function setCoverImage($imageId): void
    {
        $this->setMeta(UserSettingKey::COVER_IMAGE, (int)$imageId);
    }

    public function getCoverImageId(): int
    {
        return (int)$this->getMeta(UserSettingKey::COVER_IMAGE);
    }

    /**
     * @return Image|false
     */
    public function getCoverImage()
    {
        $imageId = $this->getCoverImageId();
        if (empty($imageId)) {
            return false;
        }

        $image = tdf_post_factory()->create($imageId);
        if (!$image instanceof Image) {
            return false;
        }

        return $image;
    }

    public function hasCoverImageUrl(string $size = 'full'): bool
    {
        $image = $this->getCoverImage();
        if (!$image) {
            return false;
        }
        return $image->getImageUrl($size) !== '';
    }

    public function getCoverImageUrl(string $size = 'full'): string
    {
        $image = $this->getCoverImage();
        if (!$image) {
            return '';
        }
        return $image->getImageUrl($size);
    }
}