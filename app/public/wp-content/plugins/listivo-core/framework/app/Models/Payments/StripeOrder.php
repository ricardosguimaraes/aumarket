<?php

namespace Tangibledesign\Framework\Models\Payments;

class StripeOrder extends Order
{
    public function getOrderId(): string
    {
        return $this->getId();
    }

    public function getLabel(): string
    {
        $userSubscription = $this->getUserSubscription();
        if ($userSubscription === null) {
            return '';
        }

        $subscription = $userSubscription->getSubscription();
        if ($subscription === null) {
            return '';
        }

        return $subscription->getName();
    }

    private function getUserSubscription(): ?UserSubscription
    {
        $userSubscriptionId = (int)$this->getMeta('user_subscription');
        if (empty($userSubscriptionId)) {
            return $this->getUserSubscriptionByStripeId();
        }

        $userSubscription = tdf_user_subscription_factory()->create($userSubscriptionId);

        return $userSubscription ?? $this->getUserSubscriptionByStripeId();
    }

    private function getUserSubscriptionByStripeId(): ?UserSubscription
    {
        $stripeSubscriptionId = $this->getMeta('stripe_subscription_id');
        if (empty($stripeSubscriptionId)) {
            return null;
        }

        return tdf_query_user_subscriptions()
            ->where('stripe_subscription_id', $stripeSubscriptionId)
            ->get()
            ->first();
    }

    public function getPrice(): string
    {
        $total = (int)$this->getMeta('total');
        $currency = $this->getMeta('currency');

        if (empty($total) || empty($currency)) {
            return '';
        }

        return str_replace('.', tdf_settings()->getDecimalSeparator(), ($total / 100))
            . ' ' . mb_strtoupper($currency, 'UTF-8');
    }

    public function getPaymentMethod(): string
    {
        $paymentMethod = $this->getMeta('payment_method');
        if (empty($paymentMethod) || !is_array($paymentMethod)) {
            return 'Stripe';
        }

        if (empty($paymentMethod['stripe_payment_method_type']) || $paymentMethod['stripe_payment_method_type'] !== 'card') {
            return 'Stripe';
        }

        $return = [];

        if (isset($paymentMethod['card_brand'])) {
            $return[] = $paymentMethod['card_brand'];
        }

        if (isset($paymentMethod['card_last4'])) {
            $return[] = '**** **** **** ' . $paymentMethod['card_last4'];
        }

        return mb_strtoupper(implode(' ', $return), 'UTF-8');
    }

    public function getInvoiceUrl(): string
    {
        return (string)$this->getMeta('pdf');
    }

}