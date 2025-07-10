<?php

namespace Tangibledesign\Framework\Providers\Stripe;

use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Invoice;
use Stripe\Webhook;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Notification\Trigger;
use UnexpectedValueException;

class StripeWebhookServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_tdf/stripe/webhook', [$this, 'webhook']);
        add_action('admin_post_nopriv_tdf/stripe/webhook', [$this, 'webhook']);
    }

    public function webhook(): void
    {
        if (!tdf_settings()->isStripeEnabled()) {
            http_response_code(400);
            exit();
        }

        if (empty(tdf_settings()->getStripeWebhookSecret())) {
            http_response_code(400);
            exit();
        }

        $payload = @file_get_contents('php://input');
        $sigHeader = $_SERVER['HTTP_STRIPE_SIGNATURE'];

        try {
            $event = Webhook::constructEvent(
                $payload, $sigHeader, tdf_settings()->getStripeWebhookSecret()
            );
        } catch (UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch (SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                if (!$event->data->object instanceof Session) {
                    return;
                }

                do_action('tdf/stripe/checkout/session/completed', $event->data->object);
                break;
            case 'invoice.paid':
                if (!$event->data->object instanceof Invoice) {
                    return;
                }

                do_action('tdf/stripe/invoice/paid', $event->data->object);
                break;
            case 'invoice.payment_failed':
                if (!$event->data->object instanceof Invoice) {
                    return;
                }

                do_action('tdf/stripe/invoice/payment_failed', $event->data->object);
                break;
            default:
                // Unexpected event type
                http_response_code(400);
                exit();
        }

        http_response_code(200);
    }

}