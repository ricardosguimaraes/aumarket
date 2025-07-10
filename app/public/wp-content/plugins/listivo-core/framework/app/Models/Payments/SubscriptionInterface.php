<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Models\User\User;

interface SubscriptionInterface
{
    public function getKey(): string;

    public function getName(): string;

    public function getText(): string;

    public function isFeatured(): bool;

    public function getLabel(): string;

    public function getDisplayPrice(): string;

    public function createUserPaymentPackage(User $user): ?RegularUserPaymentPackageInterface;
}