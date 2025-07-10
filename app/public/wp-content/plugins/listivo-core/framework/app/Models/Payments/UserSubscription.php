<?php

namespace Tangibledesign\Framework\Models\Payments;

use DateTime;
use Exception;
use Stripe\Exception\ApiErrorException;
use Tangibledesign\Framework\Actions\UserSubscription\CancelUserSubscriptionAction;
use Tangibledesign\Framework\Models\Post\PostModel;
use Tangibledesign\Framework\Models\User\User;

class UserSubscription extends PostModel
{
    public const SUPPRESS_NOTIFICATIONS = true;

    public function getSubscription(): ?SubscriptionInterface
    {
        $subscriptionId = $this->getMeta('subscription');
        if (empty($subscriptionId)) {
            return null;
        }

        if ($subscriptionId === 'free' && tdf_settings()->isFreeSubscriptionEnabled()) {
            return tdf_app('free_subscription');
        }

        return tdf_subscription_factory()->create((int)$subscriptionId);
    }

    public function isFree(): bool
    {
        return $this->getSubscription() instanceof FreeSubscription;
    }

    public function setCurrentPeriodStart(int $currentPeriodStart): void
    {
        $this->setMeta('current_period_start', $currentPeriodStart);
    }

    public function getCurrentPeriodStart(): ?DateTime
    {
        $currentPeriodStart = (int)$this->getMeta('current_period_start');
        if (empty($currentPeriodStart)) {
            return null;
        }

        try {
            return new DateTime(date('Y-m-d H:i:s', $currentPeriodStart));
        } catch (Exception $e) {
            return null;
        }
    }

    public function setCurrentPeriodEnd(int $currentPeriodEnd): void
    {
        $this->setMeta('current_period_end', $currentPeriodEnd);
    }

    public function getCurrentPeriodEnd(): ?DateTime
    {
        $currentPeriodEnd = $this->getMeta('current_period_end');
        if (empty($currentPeriodEnd)) {
            return null;
        }

        try {
            return new DateTime(date('Y-m-d H:i:s', $currentPeriodEnd));
        } catch (Exception $e) {
            return null;
        }
    }

    public function get(): ?DateTime
    {
        $expiresAt = $this->getMeta('expires_at');
        if (empty($expiresAt)) {
            return null;
        }

        try {
            return new DateTime($expiresAt);
        } catch (Exception $e) {
            return null;
        }
    }

    public function getUserId(): int
    {
        return (int)$this->getMeta('user');
    }

    public function getUser(): ?User
    {
        $userId = $this->getUserId();
        if (empty($userId)) {
            return null;
        }

        return tdf_user_factory()->create($userId);
    }

    public function setStatus(string $status): void
    {
        $this->setMeta('status', $status);
    }

    public function getStatus(): string
    {
        return (string)$this->getMeta('status');
    }

    public function getStatusLabel(): string
    {
        $status = $this->getStatus();
        if ($status === 'active') {
            return tdf_admin_string('active');
        }

        if ($status === 'canceled') {
            return tdf_admin_string('canceled');
        }

        if ($status === 'expired') {
            return tdf_admin_string('expired');
        }

        return tdf_admin_string('unknown');
    }

    public function cancel(bool $suppressNotifications = false): void
    {
        (new CancelUserSubscriptionAction())->execute($this, $suppressNotifications);
    }

    public function getStripePaymentMethod(): string
    {
        $stripePaymentMethodLabel = get_transient('tdf_stripe_payment_method_' . $this->getId());
        if ($stripePaymentMethodLabel !== false) {
            return $stripePaymentMethodLabel;
        }

        $defaultPaymentMethodId = $this->getMeta('default_payment_method');
        if (empty($defaultPaymentMethodId)) {
            return 'Stripe';
        }

        try {
            $paymentMethod = tdf_stripe()->paymentMethods->retrieve($defaultPaymentMethodId, []);
        } catch (ApiErrorException $e) {
            return 'Stripe';
        }

        if ($paymentMethod->type !== 'card') {
            return 'Stripe';
        }

        if (!isset($paymentMethod->card->brand, $paymentMethod->card->last4)) {
            return 'Stripe';
        }

        return mb_strtoupper($paymentMethod->card->brand, 'UTF-8') . ' **** **** **** ' . $paymentMethod->card->last4;
    }

    public function delete(bool $suppressNotifications = false): void
    {
        $this->cancel($suppressNotifications);

        parent::delete();
    }

    public function deletePackages(): void
    {
        tdf_query_user_payment_packages()
            ->userIn($this->getUserId())
            ->regularType()
            ->subscriptionSource()
            ->withoutExpireDate()
            ->get()
            ->each(function (RegularUserPaymentPackage $userPaymentPackage) {
                $userPaymentPackage->delete();
            });
    }

    public function applyExpireDateToPackages(): void
    {
        $currentPeriodEnd = $this->getCurrentPeriodEnd();
        if (!$currentPeriodEnd instanceof DateTime) {
            return;
        }

        $expireDate = $currentPeriodEnd->getTimestamp();

        tdf_query_user_payment_packages()
            ->userIn($this->getUserId())
            ->regularType()
            ->subscriptionSource()
            ->get()
            ->each(function (RegularUserPaymentPackage $userPaymentPackage) use ($expireDate) {
                $userPaymentPackage->setExpireDate($expireDate);
            });
    }
}