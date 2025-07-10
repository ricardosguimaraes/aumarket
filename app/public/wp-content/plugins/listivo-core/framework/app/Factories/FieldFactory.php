<?php


namespace Tangibledesign\Framework\Factories;


use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Field\AttachmentsField;
use Tangibledesign\Framework\Models\Field\EmbedField;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Field\Helpers\FieldType;
use Tangibledesign\Framework\Models\Field\LinkField;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\RichTextField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;
use WP_Post;

/**
 * Class FieldFactory
 * @package Tangibledesign\Framework\Factories
 */
class FieldFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param  WP_Post|int|null  $post
     * @return Field|false
     */
    public function create($post)
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return false;
        }

        $type = $this->getType($object);

        if ($type === FieldType::TAXONOMY) {
            return new TaxonomyField($object);
        }

        if ($type === FieldType::NUMBER) {
            return new NumberField($object);
        }

        if ($type === FieldType::PRICE) {
            return new PriceField($object);
        }

        if ($type === FieldType::GALLERY) {
            return new GalleryField($object);
        }

        if ($type === FieldType::LOCATION) {
            return new LocationField($object);
        }

        if ($type === FieldType::ATTACHMENTS) {
            return new AttachmentsField($object);
        }

        if ($type === FieldType::EMBED) {
            return new EmbedField($object);
        }

        if ($type === FieldType::RICH_TEXT) {
            return new RichTextField($object);
        }

        if ($type === FieldType::SALARY) {
            return new SalaryField($object);
        }

        if ($type === FieldType::LINK) {
            return new LinkField($object);
        }

        return new TextField($object);
    }

    /**
     * @param  WP_Post  $object
     * @return string
     */
    private function getType(WP_Post $object): string
    {
        return (string)get_post_meta($object->ID, Field::TYPE, true);
    }

}