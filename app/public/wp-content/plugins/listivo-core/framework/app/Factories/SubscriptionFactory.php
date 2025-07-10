<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Payments\Subscription;
use Tangibledesign\Framework\Models\Payments\SubscriptionInterface;
use WP_Post;

class SubscriptionFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param  WP_Post|int|null  $post
     * @return Subscription|null
     */
    public function create($post): ?SubscriptionInterface
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return null;
        }

        if ($object->post_type !== tdf_prefix().'_subscription') {
            return null;
        }

        return new Subscription($object);
    }

}