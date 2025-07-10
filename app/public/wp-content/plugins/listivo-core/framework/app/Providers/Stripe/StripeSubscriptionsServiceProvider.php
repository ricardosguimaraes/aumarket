<?php

namespace Tangibledesign\Framework\Providers\Stripe;

use Stripe\Checkout\Session;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Tangibledesign\Framework\Actions\Stripe\CreateCustomerAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\Subscription;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\General\PanelWidget;

class StripeSubscriptionsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_tdf/subscriptions/paymentMethod/update', [$this, 'updatePaymentMethod']);

        add_action('tdf/userSubscription/init', [$this, 'initUserSubscription']);
    }

    public function updatePaymentMethod(): void
    {
        Stripe::setApiKey(tdf_settings()->getStripeSecretKey());

        try {
            $session = Session::create(apply_filters(tdf_prefix() . '/stripe/updatePaymentMethodArgs', [
                'payment_method_types' => ['card'],
                'customer' => $this->getCurrentUserStripeCustomerId(),
                'setup_intent_data' => [
                    'metadata' => [
                        'customer_id' => $this->getCurrentUserStripeCustomerId(),
                        'subscription_id' => $this->getCurrentUserStripeSubscriptionId(),
                    ],
                ],
                'mode' => 'setup',
                'success_url' => PanelWidget::getUrl(PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_SUCCESS),
                'cancel_url' => PanelWidget::getUrl(PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_CANCEL),
                'billing_address_collection' => tdf_settings()->requireBillingAddressCollection() ? 'required' : 'auto',
                'customer_update' => [
                    'address' => 'auto',
                    'name' => 'auto',
                ]
            ]));
        } catch (ApiErrorException $e) {
            wp_safe_redirect(PanelWidget::getUrl(PanelWidget::ACTION_UPDATE_PAYMENT_METHOD_CANCEL));
            exit();
        }

        wp_redirect($session->url);
        exit();
    }

    public function initUserSubscription(Subscription $subscription): void
    {
        Stripe::setApiKey(tdf_settings()->getStripeSecretKey());

        try {
            $session = Session::create(apply_filters(tdf_prefix() . '/stripe/initSubscriptionArgs', [
                'line_items' => [
                    [
                        'price' => $subscription->getStripePriceId(),
                        'quantity' => 1,
                    ]
                ],
                'customer' => $this->getCurrentUserStripeCustomerId(),
                'mode' => 'subscription',
                'success_url' => PanelWidget::getUrl(PanelWidget::ACTION_SELECT_SUBSCRIPTION_SUCCESS),
                'cancel_url' => PanelWidget::getUrl(PanelWidget::ACTION_SELECT_SUBSCRIPTION_CANCEL),
                'billing_address_collection' => tdf_settings()->requireBillingAddressCollection() ? 'required' : 'auto',
                'tax_id_collection' => [
                    'enabled' => true
                ],
                'customer_update' => [
                    'address' => 'auto',
                    'name' => 'auto',
                ],
                'allow_promotion_codes' => tdf_settings()->allowPromotionCodes(),
            ]));
        } catch (ApiErrorException $e) {
            $this->errorJsonResponse([
                'message' => $e->getMessage(),
            ]);
            return;
        }

        $this->successJsonResponse([
            'redirect' => $session->url,
        ]);
    }

    private function getCurrentUserStripeSubscriptionId(): string
    {
        $user = tdf_current_user();
        if (!$user instanceof User) {
            return '';
        }

        $userSubscription = $user->getUserSubscription();
        if (!$userSubscription instanceof Subscription) {
            return '';
        }

        return $userSubscription->getMeta('stripe_subscription_id');
    }

    private function getCurrentUserStripeCustomerId(): string
    {
        $user = tdf_current_user();
        if (!$user instanceof User) {
            return '';
        }

        $stripeCustomerId = $user->getStripeCustomerId();
        if (!empty($stripeCustomerId)) {
            return $stripeCustomerId;
        }

        $stripeCustomerId = (new CreateCustomerAction())->execute($user);
        if (empty($stripeCustomerId)) {
            return '';
        }

        $user->setStripeCustomerId($stripeCustomerId);

        return $stripeCustomerId;
    }
}