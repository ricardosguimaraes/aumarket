<?php

namespace Tangibledesign\Framework\Core\Settings;

trait SetModelCardImageSizes
{
    use Setting;

    public function setListingCardImageSize($imageSize): void
    {
        $this->setSetting(SettingKey::LISTING_CARD_IMAGE_SIZE, (string)$imageSize);
    }

    public function getListingCardImageSize(): string
    {
        $imageSize = $this->getSetting(SettingKey::LISTING_CARD_IMAGE_SIZE);
        if (empty($imageSize)) {
            return tdf_app('model_card_default_image_size');
        }

        return $imageSize;
    }

    public function setListingRowImageSize($imageSize): void
    {
        $this->setSetting(SettingKey::LISTING_ROW_IMAGE_SIZE, (string)$imageSize);
    }

    public function getListingRowImageSize(): string
    {
        $imageSize = $this->getSetting(SettingKey::LISTING_ROW_IMAGE_SIZE);
        if (empty($imageSize)) {
            return tdf_app('model_row_default_image_size');
        }

        return $imageSize;
    }
}