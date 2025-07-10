<?php

namespace Tangibledesign\Framework\Models;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Post\PostModel;

class Review extends PostModel
{
    public const MODEL = 'model';
    public const TYPE = 'type';
    public const TYPE_USER = 'user';
    public const THUMB_UP_COUNT = 'thumb_up_count';
    public const THUMB_DOWN_COUNT = 'thumb_down_count';
    public const RATING = 'rating';
    public const IMAGES = 'images';
    public const AUTHOR = 'author';
    public const GUEST_HASH = 'guest_hash';

    public function setThumbUpCount(int $count): void
    {
        $this->setMeta(self::THUMB_UP_COUNT, $count);
    }

    public function getThumbUpCount(): int
    {
        return (int)$this->getMeta(self::THUMB_UP_COUNT);
    }

    public function setThumbDownCount(int $count): void
    {
        $this->setMeta(self::THUMB_DOWN_COUNT, $count);
    }

    public function getThumbDownCount(): int
    {
        return (int)$this->getMeta(self::THUMB_DOWN_COUNT);
    }

    public function increaseThumbUpCount(): void
    {
        $this->setMeta(self::THUMB_UP_COUNT, $this->getThumbUpCount() + 1);
    }

    public function decreaseThumbUpCount(): void
    {
        $this->setMeta(self::THUMB_UP_COUNT, $this->getThumbUpCount() - 1);
    }

    public function increaseThumbDownCount(): void
    {
        $this->setMeta(self::THUMB_DOWN_COUNT, $this->getThumbDownCount() + 1);
    }

    public function decreaseThumbDownCount(): void
    {
        $this->setMeta(self::THUMB_DOWN_COUNT, $this->getThumbDownCount() - 1);
    }

    public function setRating(int $rating): void
    {
        if ($rating < 1) {
            $rating = 1;
        }

        if ($rating > 5) {
            $rating = 5;
        }

        $this->setMeta(self::RATING, $rating);
    }

    public function getRating(): float
    {
        return (float)$this->getMeta(self::RATING);
    }

    public function setImageIds(array $imageIds): void
    {
        if (empty($imageIds)) {
            $this->setMeta(self::IMAGES, '0');
            return;
        }

        $this->setMeta(self::IMAGES, $imageIds);
    }

    public function getImageIds(): Collection
    {
        $imageIds = $this->getMeta(self::IMAGES);

        if (!is_array($imageIds)) {
            $imageIds = [];
        }

        return tdf_collect($imageIds)
            ->map(fn($imageId) => (int)$imageId)
            ->filter(fn($imageId) => $imageId > 0);
    }

    public function getImages(): Collection
    {
        $imageIds = $this->getImageIds();
        if ($imageIds->isEmpty()) {
            return tdf_collect();
        }

        return tdf_query_images()
            ->in($imageIds->values())
            ->orderByIn()
            ->get();
    }

    public function getAuthor(): string
    {
        return $this->getMeta(self::AUTHOR);
    }

    public function setAuthor(string $author): void
    {
        $this->setMeta(self::AUTHOR, $author);
    }

    public function getType(): string
    {
        $type = $this->getMeta(self::TYPE);
        if (empty($type)) {
            return tdf_model_post_type();
        }

        return $type;
    }

    public function setType(string $type): void
    {
        $this->setMeta(self::TYPE, $type);
    }

    public function isUserType(): bool
    {
        return $this->getType() === self::TYPE_USER;
    }

    public function isModelType(): bool
    {
        return $this->getType() === tdf_model_post_type();
    }

    public function isGuestReview(): bool
    {
        return empty($this->getUserId()) || !empty($this->getAuthor());
    }

    public function getModelId(): int
    {
        return (int)$this->getMeta(self::MODEL);
    }

    public function setModelId(int $modelId): void
    {
        $this->setMeta(self::MODEL, $modelId);
    }

    public function getModel()
    {
        $reviewSubjectId = $this->getModelId();
        if ($this->isUserType()) {
            return tdf_user_factory()->create($reviewSubjectId);
        }

        return tdf_model_factory()->create($reviewSubjectId);
    }

    public function deleteImages(): void
    {
        foreach ($this->getImages() as $image) {
            /* @var Image $image */
            $image->delete();
        }
    }

    public function getGuestHash(): string
    {
        return $this->getMeta(self::GUEST_HASH);
    }

    public function generateGuestHash(): string
    {
        $userIp = $_SERVER['REMOTE_ADDR'];
        $userAgent = $_SERVER['HTTP_USER_AGENT'];

        $hash = md5($userIp . $userAgent);

        $this->setMeta(self::GUEST_HASH, $hash);

        return $hash;
    }
}