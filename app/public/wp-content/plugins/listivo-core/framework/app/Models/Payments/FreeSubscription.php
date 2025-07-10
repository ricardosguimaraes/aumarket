<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Actions\PaymentPackage\CreateRegularUserPaymentPackageAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\User\User;

class FreeSubscription implements RegularPaymentPackageInterface, SelectSubscriptionInterface, PaymentPackageInterface, SubscriptionInterface
{
    public function getId(): int
    {
        return 0;
    }

    public function getKey(): string
    {
        return 'free';
    }

    public function isGeneral(): bool
    {
        return true;
    }

    public function getCategories(): Collection
    {
        return tdf_collect();
    }

    public function getCategoryIds(): array
    {
        return [];
    }

    public function getNumber(): int
    {
        return tdf_settings()->getFreeSubscriptionNumber();
    }

    public function getExpire(): int
    {
        return tdf_settings()->getFreeSubscriptionExpire();
    }

    public function getFeaturedExpire(): int
    {
        return tdf_settings()->getFreeSubscriptionFeaturedExpire();
    }

    public function getPrice(): float
    {
        return 0;
    }

    public function getDisplayPrice(): string
    {
        return '';
    }

    public function getLabel(): string
    {
        return tdf_settings()->getFreeSubscriptionLabel();
    }

    public function getName(): string
    {
        return tdf_settings()->getFreeSubscriptionName();
    }

    public function isRegularPackage(): bool
    {
        return true;
    }

    public function getUserAccountType(): string
    {
        return 'any';
    }

    public function isFeatured(): bool
    {
        return false;
    }

    public function getBumpsNumber(): int
    {
        return tdf_settings()->getFreeSubscriptionBumpsNumber();
    }

    public function getBumpsInterval(): int
    {
        return tdf_settings()->getFreeSubscriptionBumpsInterval();
    }

    public function getText(): string
    {
        return tdf_settings()->getFreeSubscriptionText();
    }

    public function getType(): string
    {
        return 'subscription';
    }

    public function createUserPaymentPackage(User $user): ?RegularUserPaymentPackageInterface
    {
        return (new CreateRegularUserPaymentPackageAction())->execute($user, $this);
    }
}