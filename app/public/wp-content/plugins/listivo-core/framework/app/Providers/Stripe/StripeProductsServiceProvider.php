<?php

namespace Tangibledesign\Framework\Providers\Stripe;

use Stripe\Exception\ApiErrorException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\Subscription;

class StripeProductsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('tdf/settings/saved', static function ($settingsType) {
            if ($settingsType !== 'monetization') {
                return;
            }

            do_action('tdf/subscriptions/stripe/products/sync');
        }, 10, 1);

        add_action('tdf/subscriptions/stripe/products/sync', [$this, 'syncProducts']);

        add_action('tdf/subscriptions/created', [$this, 'syncProduct']);

        add_action('tdf/subscriptions/updated', [$this, 'syncProduct']);

        add_action('tdf/subscriptions/deleted', [$this, 'deleteProduct']);
    }

    public function deleteProduct(Subscription $subscription): void
    {
        $stripeProductId = $subscription->getStripeProductId();
        if (empty($stripeProductId)) {
            return;
        }

        try {
            tdf_stripe()->products->delete($stripeProductId, []);
        } catch (ApiErrorException $e) {
        }

        $stripePriceId = $subscription->getStripePriceId();
        if (empty($stripePriceId)) {
            return;
        }

        try {
            tdf_stripe()->plans->delete($stripePriceId, []);
        } catch (ApiErrorException $e) {
        }
    }

    private function stripeSubscriptionEnabled(): bool
    {
        if (empty(tdf_settings()->getStripeSecretKey()) || empty(tdf_settings()->getStripePublishableKey())) {
            return false;
        }

        return tdf_settings()->isStripeEnabled() && tdf_settings()->subscriptionsEnabled();
    }

    public function syncProducts(): void
    {
        foreach (tdf_query_subscriptions()->get() as $subscription) {
            $this->syncProduct($subscription);
        }
    }

    public function syncProduct(Subscription $subscription): void
    {
        if (!$this->stripeSubscriptionEnabled()) {
            return;
        }

        $stripeProductId = $subscription->getStripeProductId();
        if (empty($stripeProductId)) {
            $stripeProductId = $this->createProduct($subscription);
            $subscription->setStripeProductId($stripeProductId);
        }

        if (empty($stripeProductId)) {
            return;
        }

        try {
            tdf_stripe()->products->update($stripeProductId, [
                'name' => $subscription->getName(),
            ]);
        } catch (ApiErrorException $e) {
            $stripeProductId = $this->createProduct($subscription);
            $subscription->setStripeProductId($stripeProductId);
        }

        $this->syncPrices($subscription);
    }

    private function createProduct(Subscription $subscription): string
    {
        try {
            $product = tdf_stripe()->products->create([
                'name' => $subscription->getName(),
                'type' => 'service',
            ]);
        } catch (ApiErrorException $e) {
            return '';
        }

        return $product->id;
    }

    private function syncPrices(Subscription $subscription): void
    {
        $stripePriceId = $subscription->getStripePriceId();
        if (!empty($stripePriceId)) {
            try {
                tdf_stripe()->plans->delete($stripePriceId, []);
            } catch (ApiErrorException $e) {
            }
        }

        $stripePriceId = $this->createPrice($subscription);
        $subscription->setStripePriceId($stripePriceId);
    }

    private function createPrice(Subscription $subscription): string
    {
        try {
            $price = tdf_stripe()->prices->create([
                'product' => $subscription->getStripeProductId(),
                'unit_amount' => $subscription->getStripePrice() * 100,
                'currency' => $subscription->getStripeCurrency(),
                'recurring' => [
                    'interval' => 'month',
                ],
            ]);
        } catch (ApiErrorException $e) {
            return '';
        }

        return $price->id;
    }

}