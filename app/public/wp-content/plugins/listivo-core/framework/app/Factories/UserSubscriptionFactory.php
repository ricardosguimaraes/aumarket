<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use WP_Post;

class UserSubscriptionFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param WP_Post|int|null $post
     * @return UserSubscription|null
     */
    public function create($post): ?UserSubscription
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return null;
        }

        if ($object->post_type !== tdf_prefix() . '_user_subs') {
            return null;
        }

        return new UserSubscription($object);
    }
}