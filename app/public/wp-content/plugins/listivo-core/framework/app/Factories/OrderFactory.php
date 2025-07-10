<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Payments\Order;
use Tangibledesign\Framework\Models\Payments\StripeOrder;
use Tangibledesign\Framework\Models\Payments\WooCommerceOrder;
use WP_Post;

class OrderFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param  WP_Post|int|null  $post
     * @return Order|null
     */
    public function create($post): ?Order
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return null;
        }

        if ($object->post_type !== tdf_prefix().'_order') {
            return null;
        }

        $type = get_post_meta($object->ID, 'type', true);
        if ($type === Order::TYPE_WOOCOMMERCE) {
            return new WooCommerceOrder($object);
        }

        if ($type === Order::TYPE_STRIPE) {
            return new StripeOrder($object);
        }

        return null;
    }

}