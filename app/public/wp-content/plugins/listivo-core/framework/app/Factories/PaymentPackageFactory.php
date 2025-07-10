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
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpPaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackageInterface;
use WP_Post;

/**
 * Class FieldFactory
 * @package Tangibledesign\Framework\Factories
 */
class PaymentPackageFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param  WP_Post|int|null  $post
     * @return PaymentPackageInterface|null
     */
    public function create($post): ?PaymentPackageInterface
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return null;
        }

        $type = $this->getType($object);

        if ($type === BasePaymentPackage::TYPE_BUMP) {
            return new BumpPaymentPackage($object);
        }

        return new PaymentPackage($object);
    }

    /**
     * @param  WP_Post  $object
     * @return string
     */
    private function getType(WP_Post $object): string
    {
        return (string)get_post_meta($object->ID, BasePaymentPackage::TYPE, true);
    }

}