<?php

namespace Tangibledesign\Framework\Providers\Fields;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\LinkField;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;

class FieldsServiceProvider extends ServiceProvider
{

    public function initiation(): void
    {
        $this->container['fields'] = static function () {
            return tdf_query_fields()->get();
        };

        $this->container['location_fields'] = static function () {
            return tdf_ordered_fields()->filter(static function ($field) {
                return $field instanceof LocationField;
            });
        };

        $this->container['text_fields'] = static function () {
            return tdf_ordered_fields()->filter(static function ($field) {
                return $field instanceof TextField;
            });
        };

        $this->container['number_fields'] = static function () {
            return tdf_ordered_fields()->filter(static function ($field) {
                return $field instanceof NumberField;
            });
        };

        $this->container['price_fields'] = static function () {
            return tdf_ordered_fields()->filter(static function ($field) {
                return $field instanceof PriceField;
            });
        };

        $this->container['taxonomy_fields'] = static function () {
            return tdf_ordered_fields()->filter(static function ($field) {
                return $field instanceof TaxonomyField;
            });
        };

        $this->container['link_fields'] = static function () {
            return tdf_ordered_fields()->filter(static function ($field) {
                return $field instanceof LinkField;
            });
        };

        $this->container['ordered_fields'] = static function () {
            return tdf_collect(tdf_settings()->getFieldsOrder())
                ->map(function ($fieldId) {
                    foreach (tdf_fields() as $field) {
                        /* @var Field $field */
                        if ($field->getId() === $fieldId) {
                            return $field;
                        }
                    }

                    return false;
                })
                ->filter(static function ($field) {
                    return $field !== false && $field !== null;
                });
        };
    }

}