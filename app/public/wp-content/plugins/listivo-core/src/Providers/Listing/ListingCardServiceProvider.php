<?php


namespace Tangibledesign\Listivo\Providers\Listing;


use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;

class ListingCardServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['card_show_views'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return true;
            }

            return !empty((int)$kit->get_settings_for_display('listivo_listing_card_show_views'));
        };

        $this->container['card_show_user'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return true;
            }

            return !empty((int)$kit->get_settings_for_display('listivo_listing_card_show_user'));
        };

        $this->container['card_main_value_text_when_empty'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return '';
            }

            return $kit->get_settings_for_display('listivo_listing_main_value_when_empty');
        };

        $this->container['card_main_value_fields'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return tdf_collect();
            }

            /** @noinspection NullPointerExceptionInspection */
            $value = tdf_current_kit()->get_settings_for_display('listivo_listing_main_value');
            if (!is_array($value) || empty($value)) {
                return tdf_collect();
            }

            return tdf_collect($value)
                ->map(static function ($fieldKey) {
                    return tdf_currency_fields()->find(static function ($field) use ($fieldKey) {
                        /* @var Field $field */
                        return $field->getKey() === $fieldKey;
                    });
                })->filter(static function ($field) {
                    return $field !== false && $field !== null;
                });
        };

        $this->container['card_gallery'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return true;
            }

            return !empty((int)$kit->get_settings_for_display('listivo_listing_card_gallery'));
        };

        $this->container['card_show_user_phone'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return true;
            }

            return !empty((int)$kit->get_settings_for_display('listivo_card_show_user_phone'));
        };

        $this->container['card_hide_user_phone_at_start'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return true;
            }

            return !empty((int)$kit->get_settings_for_display('listivo_card_hide_user_phone_at_start'));
        };

        $this->container['card_gallery_field'] = static function () {
            if (tdf_gallery_fields()->count() === 1) {
                return tdf_gallery_fields()->first(false);
            }

            $kit = tdf_current_kit();
            if (!$kit) {
                return tdf_gallery_fields()->first(false);
            }

            $fieldKey = $kit->get_settings_for_display('listivo_listing_card_gallery_field');
            if (empty($fieldKey)) {
                return tdf_gallery_fields()->first(false);
            }

            $field = tdf_gallery_fields()->find(static function ($field) use ($fieldKey) {
                return $field->getKey() === $fieldKey;
            });

            if (!$field instanceof GalleryField) {
                return tdf_gallery_fields()->first(false);
            }

            return $field;
        };

        $this->container['card_attribute_fields'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return tdf_collect();
            }

            $options = $kit->get_settings_for_display('listivo_listing_attributes');
            if (!is_array($options) || empty($options)) {
                return tdf_collect();
            }

            return tdf_collect($options)
                ->map(static function ($fieldData) {
                    $fieldData['field'] = tdf_simple_text_value_fields()
                        ->find(static function ($field) use ($fieldData) {
                            /* @var SimpleTextValue $field */
                            return tdf_prefix() . '_' . $field->getId() === $fieldData['field'];
                        });

                    return $fieldData;
                })
                ->filter(static function ($fieldData) {
                    return $fieldData['field'] !== false && $fieldData['field'] !== null;
                });
        };

        $this->container['row_attribute_fields'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return tdf_collect();
            }

            $options = $kit->get_settings_for_display('listivo_row_listing_attributes');
            if (!is_array($options) || empty($options)) {
                return tdf_collect();
            }

            return tdf_collect($options)
                ->map(static function ($fieldData) {
                    $fieldData['field'] = tdf_simple_text_value_fields()
                        ->find(static function ($field) use ($fieldData) {
                            /* @var SimpleTextValue $field */
                            return tdf_prefix() . '_' . $field->getId() === $fieldData['field'];
                        });

                    return $fieldData;
                })
                ->filter(static function ($fieldData) {
                    return $fieldData['field'] !== false && $fieldData['field'] !== null;
                });
        };

        $this->container['card_quick_view_category_fields'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return tdf_collect();
            }

            $options = $kit->get_settings_for_display('listivo_quick_preview_categories');
            if (!is_array($options) || empty($options)) {
                return tdf_collect();
            }

            return tdf_collect($options)
                ->map(static function ($fieldData) {
                    return $fieldData['field'];
                })
                ->map(static function ($fieldKey) {
                    return tdf_simple_text_value_fields()->find(static function ($field) use ($fieldKey) {
                        /* @var SimpleTextValue $field */
                        return tdf_prefix() . '_' . $field->getId() === $fieldKey;
                    });
                })->filter(static function ($field) {
                    return $field !== false && $field !== null;
                });
        };

        $this->container['card_quick_view_attribute_fields'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return tdf_collect();
            }

            $options = $kit->get_settings_for_display('listivo_quick_preview_attributes');
            if (!is_array($options) || empty($options)) {
                return tdf_collect();
            }

            return tdf_collect($options)
                ->map(static function ($fieldData) {
                    $fieldData['field'] = tdf_simple_text_value_fields()->find(static function ($field) use ($fieldData) {
                        /* @var SimpleTextValue $field */
                        return tdf_prefix() . '_' . $field->getId() === $fieldData['field'];
                    });

                    return $fieldData;
                })
                ->filter(static function ($fieldData) {
                    return !empty($fieldData['field']);
                });
        };

        $this->container['card_label_fields_ids'] = static function () {
            return tdf_app('card_label_fields')->map(static function ($field) {
                if ($field === 'featured') {
                    return 'featured';
                }

                return $field->getId();
            })->values();
        };

        $this->container['card_label_fields'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return tdf_collect();
            }

            $options = $kit->get_settings_for_display('listivo_listing_card_label');
            if (!is_array($options) || empty($options)) {
                return tdf_collect();
            }

            return tdf_collect($options)
                ->map(static function ($option) {
                    $labelOption = $option['value'] ?? '';

                    if ($labelOption === 'featured') {
                        return $labelOption;
                    }

                    return tdf_fields()->find(static function ($field) use ($labelOption) {
                        /* @var Field $field */
                        return $field->getKey() === $labelOption;
                    });
                })
                ->filter(static function ($labelOption) {
                    return $labelOption !== false;
                });
        };

        $this->container['card_location_field'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return tdf_collect();
            }

            $options = $kit->get_settings_for_display('listivo_listing_card_location');
            if (!is_array($options) || empty($options)) {
                return tdf_collect();
            }

            return tdf_collect($options)
                ->map(static function ($fieldData) {
                    return $fieldData['field'];
                })
                ->map(static function ($fieldKey) {
                    if ($fieldKey === 'user_location') {
                        return 'user_location';
                    }

                    return tdf_fields()->find(static function ($field) use ($fieldKey) {
                        /* @var LocationField $field */
                        if ($field->getKey() !== $fieldKey) {
                            return false;
                        }

                        return $field instanceof LocationField
                            || $field instanceof TextField
                            || $field instanceof TaxonomyField;
                    });
                });
        };

        $this->container['listing_card_default_image_size'] = static function () {
            return [
                'key' => 'listivo_360_240',
                'width' => 360,
                'height' => 240,
            ];
        };

        $this->container['listing_card_image_size'] = static function () {
            if (!tdf_current_kit()) {
                return tdf_app('listing_card_default_image_size');
            }

            /** @noinspection NullPointerExceptionInspection */
            $imageSizeKey = tdf_current_kit()->get_settings_for_display('listivo_listing_card_image_size');
            if (empty($imageSizeKey)) {
                return tdf_app('listing_card_default_image_size');
            }

            foreach (tdf_app('image_sizes') as $key => $imageSize) {
                if ($imageSizeKey === $key) {
                    return [
                        'key' => $key,
                        'width' => $imageSize['width'],
                        'height' => $imageSize['height'],
                    ];
                }
            }

            return tdf_app('listing_card_default_image_size');
        };

        $this->container['listing_row_default_image_size'] = static function () {
            return [
                'key' => 'listivo_360_320',
                'width' => 360,
                'height' => 320,
            ];
        };

        $this->container['listing_row_image_size'] = static function () {
            if (!tdf_current_kit()) {
                return tdf_app('listing_row_default_image_size');
            }

            /** @noinspection NullPointerExceptionInspection */
            $imageSizeKey = tdf_current_kit()->get_settings_for_display('listivo_listing_row_image_size');
            if (empty($imageSizeKey)) {
                return tdf_app('listing_row_default_image_size');
            }

            foreach (tdf_app('image_sizes') as $key => $imageSize) {
                if ($imageSizeKey === $key) {
                    return [
                        'key' => $key,
                        'width' => $imageSize['width'],
                        'height' => $imageSize['height'],
                    ];
                }
            }

            return tdf_app('listing_row_default_image_size');
        };

        $this->container['listing_card_featured_only'] = static function () {
            if (!tdf_current_kit()) {
                return false;
            }

            /** @noinspection NullPointerExceptionInspection */
            return tdf_current_kit()->get_settings_for_display('listivo_listing_card_label_type') === 'featured';
        };

        $this->container['card_v4_show_user'] = static function () {
            if (!tdf_current_kit()) {
                return false;
            }

            /** @noinspection NullPointerExceptionInspection */
            return !empty(tdf_current_kit()->get_settings_for_display('card_v4_user'));
        };

        $this->container['card_v4_show_date_diff'] = static function () {
            if (!tdf_current_kit()) {
                return false;
            }

            /** @noinspection NullPointerExceptionInspection */
            return !empty(tdf_current_kit()->get_settings_for_display('card_v4_date'));
        };

        $this->container['card_v4_show_description'] = static function () {
            if (!tdf_current_kit()) {
                return false;
            }

            /** @noinspection NullPointerExceptionInspection */
            return !empty(tdf_current_kit()->get_settings_for_display('card_v4_show_description'));
        };

        $this->container['card_v4_show_account_type'] = static function () {
            if (!tdf_current_kit()) {
                return false;
            }

            /** @noinspection NullPointerExceptionInspection */
            return !empty((int)tdf_current_kit()->get_settings_for_display('card_v4_show_account_type'));
        };

        $this->container['card_v4_account_type_pattern'] = static function () {
            if (!tdf_current_kit()) {
                return '';
            }

            /** @noinspection NullPointerExceptionInspection */
            $pattern = (string)tdf_current_kit()->get_settings_for_display('card_v4_account_type_label');
            if (empty($pattern)) {
                return tdf_string('account_type') . ': %s';
            }

            return $pattern;
        };

        $this->container['card_v4_rating'] = static function () {
            $kit = tdf_current_kit();
            if (!tdf_current_kit()) {
                return '';
            }

            $ratingType = $kit->get_settings_for_display('card_v4_rating');
            if (empty($ratingType) || $ratingType === 'none') {
                return '';
            }

            return $ratingType;
        };

        $this->container['card_v4_ratings_count'] = static function () {
            $kit = tdf_current_kit();
            if (!tdf_current_kit()) {
                return '';
            }

            return !empty($kit->get_settings_for_display('card_v4_show_ratings_count'));
        };

        $this->container['row_v2_show_user'] = static function () {
            if (!tdf_current_kit()) {
                return false;
            }

            /** @noinspection NullPointerExceptionInspection */
            return !empty(tdf_current_kit()->get_settings_for_display('row_v2_user'));
        };

        $this->container['row_v2_show_date_diff'] = static function () {
            if (!tdf_current_kit()) {
                return false;
            }

            /** @noinspection NullPointerExceptionInspection */
            return !empty(tdf_current_kit()->get_settings_for_display('row_v2_date'));
        };

        $this->container['row_v2_rating'] = static function () {
            $kit = tdf_current_kit();
            if (!tdf_current_kit()) {
                return '';
            }

            $ratingType = $kit->get_settings_for_display('row_v2_rating');
            if (empty($ratingType)) {
                return '';
            }

            return $ratingType;
        };

        $this->container['row_v2_ratings_count'] = static function () {
            $kit = tdf_current_kit();
            if (!tdf_current_kit()) {
                return '';
            }

            return !empty($kit->get_settings_for_display('row_v2_show_ratings_count'));
        };

        $this->container['card_max_number_of_images'] = static function () {
            $kit = tdf_current_kit();
            if (!$kit) {
                return 5;
            }

            $number = (int)$kit->get_settings_for_display('listivo_listing_card_max_images');
            if (empty($number)) {
                return 20;
            }

            return $number;
        };
    }

}