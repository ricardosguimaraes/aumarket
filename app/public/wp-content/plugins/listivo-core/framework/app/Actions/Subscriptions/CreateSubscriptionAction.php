<?php

namespace Tangibledesign\Framework\Actions\Subscriptions;

use Tangibledesign\Framework\Models\Payments\Subscription;
use Tangibledesign\Framework\Models\Post\PostStatus;

class CreateSubscriptionAction
{

    public function execute(array $data): ?Subscription
    {
        $name = $data['name'] ?? 'New Subscription';

        $subscriptionId = wp_insert_post([
            'post_title' => $name,
            'post_type' => tdf_prefix().'_subscription',
            'post_status' => PostStatus::PUBLISH,
        ]);

        if (is_wp_error($subscriptionId)) {
            return null;
        }

        $subscription = tdf_subscription_factory()->create($subscriptionId);
        if (!$subscription instanceof Subscription) {
            return null;
        }

        $subscription->setNumber(5);
        $subscription->setExpire(30);
        $subscription->setFeaturedExpire(5);
        $subscription->setBumpsNumber(3);
        $subscription->setBumpsInterval(7);
        $subscription->setDisplayPrice('$10');
        $subscription->setStripePrice(10);

        return $subscription;
    }

}