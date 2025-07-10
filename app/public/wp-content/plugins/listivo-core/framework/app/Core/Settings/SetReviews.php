<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetReviews
{
    use Setting;

    public function setReviewsEnabled($enabled): void
    {
        $this->setSetting(SettingKey::REVIEWS_ENABLED, (int)$enabled);
    }

    public function reviewsEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::REVIEWS_ENABLED));
    }

    public function setReviewsModerationEnabled($enabled): void
    {
        $this->setSetting(SettingKey::REVIEWS_MODERATION_ENABLED, (int)$enabled);
    }

    public function isReviewsModerationEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::REVIEWS_MODERATION_ENABLED));
    }

    public function setReviewsThumbsEnabled($enabled): void
    {
        $this->setSetting(SettingKey::REVIEWS_THUMBS_ENABLED, (int)$enabled);
    }

    public function reviewsThumbsEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::REVIEWS_THUMBS_ENABLED));
    }

    public function setReviewsImagesEnabled($enabled): void
    {
        $this->setSetting(SettingKey::REVIEWS_IMAGES_ENABLED, (int)$enabled);
    }

    public function reviewsImagesEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::REVIEWS_IMAGES_ENABLED));
    }

    public function setReviewsImagesNumber($number): void
    {
        $this->setSetting(SettingKey::REVIEWS_IMAGES_NUMBER, (int)$number);
    }

    public function getReviewsImagesNumber(): int
    {
        $number = (int)$this->getSetting(SettingKey::REVIEWS_IMAGES_NUMBER);
        if (empty($number)) {
            return 20;
        }

        return $number;
    }

    public function setReviewsImagesSize($size): void
    {
        $this->setSetting(SettingKey::REVIEWS_IMAGES_SIZE, (int)$size);
    }

    public function getReviewsImagesSize(): int
    {
        $size = (int)$this->getSetting(SettingKey::REVIEWS_IMAGES_SIZE);
        if (empty($size)) {
            return 8;
        }

        return $size;
    }

    public function setReviewsAllowGuests($enabled): void
    {
        $this->setSetting(SettingKey::REVIEWS_ALLOW_GUESTS, (int)$enabled);
    }

    public function reviewsAllowGuests(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::REVIEWS_ALLOW_GUESTS));
    }

    public function setReviewMinLength($length): void
    {
        $this->setSetting(SettingKey::REVIEW_MIN_LENGTH, (int)$length);
    }

    public function getReviewMinLength(): int
    {
        return (int)$this->getSetting(SettingKey::REVIEW_MIN_LENGTH);
    }

    public function setReviewMaxLength($length): void
    {
        $this->setSetting(SettingKey::REVIEW_MAX_LENGTH, (int)$length);
    }

    public function getReviewMaxLength(): int
    {
        return (int)$this->getSetting(SettingKey::REVIEW_MAX_LENGTH);
    }

    public function setReviewCutoffLength(int $length): void
    {
        $this->setSetting(SettingKey::REVIEW_CUTOFF_LENGTH, $length);
    }

    public function getReviewCutoffLength(): int
    {
        $reviewCutoffLength = (int)$this->getSetting(SettingKey::REVIEW_CUTOFF_LENGTH);
        if (empty($reviewCutoffLength)) {
            return 200;
        }

        return $reviewCutoffLength;
    }

    public function setDeleteReviewImagesOnDelete($delete): void
    {
        $this->setSetting(SettingKey::DELETE_REVIEW_IMAGES_ON_DELETE, (int)$delete);
    }

    public function deleteReviewImagesOnDelete(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::DELETE_REVIEW_IMAGES_ON_DELETE));
    }

    public function setSingleReviewPerModel($enabled): void
    {
        $this->setSetting(SettingKey::SINGLE_REVIEW_PER_MODEL, (int)$enabled);
    }

    public function singleReviewPerModel(): bool
    {
        return true;
    }
}