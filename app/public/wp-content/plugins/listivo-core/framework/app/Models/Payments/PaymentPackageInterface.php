<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Models\User\User;

interface PaymentPackageInterface
{
    public function getPrice(): float;

    public function getDisplayPrice(): string;

    public function getLabel(): string;

    public function getName(): string;

    public function getType(): string;

    public function getText(): string;

    public function isFeatured(): bool;

    public function createUserPaymentPackage(User $user);

    public function isRegularPackage(): bool;

}