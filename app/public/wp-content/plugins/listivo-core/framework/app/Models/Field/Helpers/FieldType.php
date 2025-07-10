<?php

namespace Tangibledesign\Framework\Models\Field\Helpers;

class FieldType
{
    public const TAXONOMY = 'taxonomy';
    public const TEXT = 'text';
    public const NUMBER = 'number';
    public const PRICE = 'price';
    public const SALARY = 'salary';
    public const LOCATION = 'location';
    public const EMBED = 'embed';
    public const GALLERY = 'gallery';
    public const ATTACHMENTS = 'attachments';
    public const RICH_TEXT = 'rich_text';
    public const LINK = 'link';

    public static function getAll(): array
    {
        return apply_filters('tdf/customFields/types', [
            self::TAXONOMY => tdf_admin_string('taxonomy'),
            self::TEXT => tdf_admin_string('text'),
            self::RICH_TEXT => tdf_admin_string('rich_text'),
            self::NUMBER => tdf_admin_string('number'),
            self::PRICE => tdf_admin_string('price'),
            self::LOCATION => tdf_admin_string('location'),
            self::EMBED => tdf_admin_string('embed'),
            self::GALLERY => tdf_admin_string('gallery'),
            self::ATTACHMENTS => tdf_admin_string('attachments'),
            self::SALARY => tdf_admin_string('salary'),
            self::LINK => tdf_admin_string('link'),
        ]);
    }
}