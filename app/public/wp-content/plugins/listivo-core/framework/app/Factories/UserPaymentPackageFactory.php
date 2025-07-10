<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Payments\BaseUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\UserPaymentPackageInterface;
use WP_Post;

class UserPaymentPackageFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param WP_Post|int|null $post
     * @return UserPaymentPackageInterface|false
     */
    public function create($post)
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return false;
        }

        $type = $this->getType($object);

        if ($type === BaseUserPaymentPackage::TYPE_BUMP) {
            return new BumpUserPaymentPackage($object);
        }

        return new RegularUserPaymentPackage($object);
    }

    /**
     * @param WP_Post $object
     * @return string
     */
    private function getType(WP_Post $object): string
    {
        return (string)get_post_meta($object->ID, BaseUserPaymentPackage::TYPE, true);
    }

}