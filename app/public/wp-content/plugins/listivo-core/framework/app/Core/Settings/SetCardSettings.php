<?php


namespace Tangibledesign\Framework\Core\Settings;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;

/**
 * Trait SetCardSettings
 * @package Tangibledesign\Framework\Core\Settings
 */
trait SetCardSettings
{
    use Setting;

    /**
     * @param array $ids
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setListingCardAttributes($ids): void
    {
        $this->setSetting(SettingKey::LISTING_CARD_ATTRIBUTES, $ids);
    }

    /**
     * @return array
     */
    public function getListingCardAttributeIds(): array
    {
        $ids = $this->getSetting(SettingKey::LISTING_CARD_ATTRIBUTES);

        if (!is_array($ids) || empty($ids)) {
            return [];
        }

        return tdf_collect($ids)
            ->map(static function ($id) {
                return (int)$id;
            })
            ->values();
    }

    /**
     * @return Collection
     */
    public function getListingCardAttributes(): Collection
    {
        return tdf_collect($this->getListingCardAttributeIds())
            ->map(static function ($attributeId) {
                return tdf_simple_text_value_fields()->find(static function ($simpleTextValueField) use ($attributeId) {
                    /* @var SimpleTextValue $simpleTextValueField */
                    return $simpleTextValueField->getId() === $attributeId;
                });
            })->filter(static function ($simpleTextValueField) {
                return $simpleTextValueField !== false && $simpleTextValueField !== null;
            });
    }

    /**
     * @param int $mainValueFieldIds
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setListingCardMainValueFields($mainValueFieldIds): void
    {
        $this->setSetting(SettingKey::LISTING_CARD_MAIN_VALUE_FIELDS, $mainValueFieldIds);
    }

    /**
     * @return array
     */
    public function getListingCardMainFieldIds(): array
    {
        $fieldIds = $this->getSetting(SettingKey::LISTING_CARD_MAIN_VALUE_FIELDS);

        if (empty($fieldIds)) {
            return [];
        }

        if (!is_array($fieldIds)) {
            return [(int)$fieldIds];
        }

        return tdf_collect($fieldIds)->map(static function ($fieldId) {
            return (int)$fieldId;
        })->values();
    }

    /**
     * @param int $galleryFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setListingCardGalleryField($galleryFieldId): void
    {
        $this->setSetting(SettingKey::LISTING_CARD_GALLERY_FIELD, (int)$galleryFieldId);
    }

    /**
     * @return int
     */
    public function getListingCardGalleryFieldId(): int
    {
        return (int)$this->getSetting(SettingKey::LISTING_CARD_GALLERY_FIELD);
    }

    /**
     * @param string|int $location
     */
    public function setListingCardLocation($location): void
    {
        $this->setSetting(SettingKey::LISTING_CARD_LOCATION, $location);
    }

    /**
     * @return string[]
     */
    public function getListingCardLocation(): array
    {
        $location = $this->getSetting(SettingKey::LISTING_CARD_LOCATION);
        if (empty($location)) {
            return ['user_location'];
        }

        if (!is_array($location)) {
            $location = [(string)$location];
        }

        return tdf_collect($location)->map(static function ($l) {
            if ($l !== 'user_location') {
                return (int)$l;
            }

            return $l;
        })->values();
    }

    /**
     * @return array
     */
    public function getSelectedListingCardLocationFields(): array
    {
        return tdf_collect($this->getListingCardLocation())
            ->map(static function ($id) {
                $label = '';

                if ($id === 'user_location') {
                    $label = 'User Location';
                } else {
                    /* @var Field $field */
                    $field = tdf_fields()->find(static function ($field) use ($id) {
                        /* @var Field $field */
                        return $field->getId() === $id;
                    });
                    if ($field) {
                        $label = $field->getName();
                    }
                }

                return [
                    'id' => $id,
                    'label' => $label,
                ];
            })
            ->values();
    }

    /**
     * @return array|Field[]
     */
    public function getNotSelectedListingCardLocationFields(): array
    {
        $fieldIds = $this->getListingCardLocation();

        return tdf_fields()->filter(static function ($field) use ($fieldIds) {
            if (!$field instanceof TextField && !$field instanceof TaxonomyField && !$field instanceof LocationField) {
                return false;
            }

            return !in_array($field->getId(), $fieldIds, true);
        })->values();
    }

    /**
     * @return PriceField|SalaryField|Collection
     */
    public function getCardMainValueFields(): Collection
    {
        return tdf_app('card_main_value_fields');
    }

    /**
     * @return GalleryField|false
     */
    public function getCardGalleryField()
    {
        return tdf_app('card_gallery_field');
    }

    public function getCardLocationField()
    {
        return tdf_app('card_location_field');
    }

    /**
     * @param array $listingCardLabel
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setListingCardLabel($listingCardLabel): void
    {
        $this->setSetting(SettingKey::LISTING_CARD_LABEL, $listingCardLabel);
    }

    /**
     * @return array
     */
    public function getListingCardLabel(): array
    {
        $options = $this->getSetting(SettingKey::LISTING_CARD_LABEL);
        if (empty($options) || !is_array($options)) {
            return [];
        }

        return tdf_collect($options)->map(static function ($option) {
            if ($option === 'featured') {
                return $option;
            }

            return (int)$option;
        })->values();
    }

    /**
     * @param int $enabled
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setListingCardGallery($enabled): void
    {
        $this->setSetting(SettingKey::LISTING_CARD_GALLERY, (int)$enabled);
    }

    /**
     * @return bool
     */
    public function isListingCardGalleryEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::LISTING_CARD_GALLERY));
    }

    /**
     * @param int $number
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setListingCardGalleryImageNumber($number): void
    {
        $this->setSetting(SettingKey::LISTING_CARD_GALLERY_IMAGE_NUMBER, (int)$number);
    }

    /**
     * @return int
     */
    public function getListingCardGalleryImageNumber(): int
    {
        return (int)tdf_app('card_max_number_of_images');
    }

}