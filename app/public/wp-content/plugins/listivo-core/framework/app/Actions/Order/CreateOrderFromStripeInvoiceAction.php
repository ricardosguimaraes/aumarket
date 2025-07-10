<?php

namespace Tangibledesign\Framework\Actions\Order;

use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Invoice;
use Stripe\PaymentMethod;
use Tangibledesign\Framework\Models\Payments\OrderStatus;
use Tangibledesign\Framework\Models\Payments\UserSubscription;
use Tangibledesign\Framework\Models\User\User;

class CreateOrderFromStripeInvoiceAction
{
    public function execute(Invoice $invoice): int
    {
        $orderId = wp_insert_post($this->getArgs($invoice));
        if (is_wp_error($orderId)) {
            return 0;
        }

        return $orderId;
    }

    private function getArgs(Invoice $invoice): array
    {
        return [
            'post_type' => tdf_prefix() . '_order',
            'post_title' => $invoice->id,
            'post_status' => 'publish',
            'meta_input' => $this->getMetaInput($invoice),
            'post_author' => $this->getUserIdByStripeCustomerId($invoice->customer),
        ];
    }

    private function getMetaInput(Invoice $invoice): array
    {
        $userSubscription = $this->getUserSubscription($invoice->subscription);

        $meta = [
            'type' => 'stripe',
            'stripe_invoice_id' => $invoice->id,
            'stripe_charge_id' => $invoice->charge,
            'stripe_payment_intent_id' => $invoice->payment_intent,
            'stripe_status' => $invoice->status,
            'stripe_subscription_id' => $invoice->subscription,
            'current_period_start' => $invoice->period_start,
            'current_period_end' => $invoice->period_end,
            'number' => $invoice->number,
            'total' => $invoice->total,
            'currency' => $invoice->currency,
            'pdf' => $invoice->invoice_pdf,
            'status' => OrderStatus::COMPLETED,
            'created_at' => $invoice->created,
            'updated_at' => $invoice->created,
            'payment_method' => $this->getStripePaymentMethodDetails($invoice->charge),
        ];

        if ($userSubscription !== null) {
            $meta['user_subscription'] = $userSubscription->getId();
        }

        return $meta;
    }

    private function getStripePaymentMethodDetails(?string $stripeChargeId): array
    {
        if (!$stripeChargeId) {
            return [];
        }

        $stripeCharge = $this->getStripeCharge($stripeChargeId);
        if (!$stripeCharge instanceof Charge) {
            return [];
        }

        $stripePaymentMethod = $this->getStripePaymentMethod($stripeCharge->payment_method);
        if (!$stripePaymentMethod instanceof PaymentMethod) {
            return [];
        }

        $return = [
            'stripe_payment_method_id' => $stripePaymentMethod->id,
            'stripe_payment_method_type' => $stripePaymentMethod->type,
        ];

        if (isset($stripePaymentMethod->card->brand)) {
            $return['card_brand'] = $stripePaymentMethod->card->brand;
        }

        if (isset($stripePaymentMethod->card->last4)) {
            $return['card_last4'] = $stripePaymentMethod->card->last4;
        }

        if (isset($stripePaymentMethod->card->exp_month)) {
            $return['card_exp_month'] = $stripePaymentMethod->card->exp_month;
        }

        if (isset($stripePaymentMethod->card->exp_year)) {
            $return['card_exp_year'] = $stripePaymentMethod->card->exp_year;
        }

        return $return;
    }

    private function getStripePaymentMethod(string $stripePaymentMethodId): ?PaymentMethod
    {
        try {
            return tdf_stripe()->paymentMethods->retrieve($stripePaymentMethodId, []);
        } catch (ApiErrorException $e) {
            return null;
        }
    }

    private function getStripeCharge(string $stripeChargeId): ?Charge
    {
        try {
            return tdf_stripe()->charges->retrieve($stripeChargeId, []);
        } catch (ApiErrorException $e) {
            return null;
        }
    }

    private function getUserSubscription(string $stripeSubscriptionId): ?UserSubscription
    {
        $userSubscription = tdf_query_user_subscriptions()
            ->where('stripe_subscription_id', $stripeSubscriptionId)
            ->first();

        if (!$userSubscription) {
            return null;
        }

        return $userSubscription;
    }

    private function getUserIdByStripeCustomerId(string $stripeCustomerId): int
    {
        $user = tdf_query_users()->whereStripeCustomerId($stripeCustomerId)->get()->first();
        if (!$user instanceof User) {
            return 0;
        }

        return $user->getId();
    }
}