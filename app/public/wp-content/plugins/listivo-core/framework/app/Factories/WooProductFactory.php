<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use WC_Order;
use WC_Order_Item_Product;
use WC_Product;
use WP_Post;

class WooProductFactory
{
    use GetPostObject;

    /**
     * @param  WP_Post|int|WC_Order|null  $object
     * @return WC_Product|false
     */
    public function create($object)
    {
        if ($object instanceof WC_Order) {
            return $this->getFromOrder($object);
        }

        $post = $this->getPostObject($object);
        if (!$post) {
            return false;
        }

        return wc_get_product($post);
    }

    /**
     * @param  WC_Order  $order
     * @return false|WC_Product|null
     */
    private function getFromOrder(WC_Order $order)
    {
        foreach ($order->get_items() as $item) {
            $productId = (new WC_Order_Item_Product($item->get_id()))->get_product_id();
            $product = wc_get_product($productId);
            if ($product instanceof WC_Product) {
                return $product;
            }
        }

        return false;
    }

}