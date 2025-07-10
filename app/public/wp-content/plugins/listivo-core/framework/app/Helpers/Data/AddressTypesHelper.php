<?php

namespace Tangibledesign\Framework\Helpers\Data;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;

class AddressTypesHelper
{
    private static ?AddressTypesHelper $instance = null;

    private function __construct()
    {
    }

    public static function make(): AddressTypesHelper
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getAddressTypes(): array
    {
        $addressTypes = [
            'user_location' => tdf_admin_string('user_address'),
        ];

        foreach ($this->getAddressFields() as $field) {
            /* @var Field $field */
            $addressTypes[$field->getKey()] = $field->getName();
        }

        return $addressTypes;
    }

    private function getAddressFields(): Collection
    {
        return tdf_ordered_fields()
            ->filter(static function ($field) {
                return $field instanceof LocationField
                    || $field instanceof TextField
                    || $field instanceof TaxonomyField;
            });
    }
}