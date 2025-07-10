<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Term\CustomTerm;

interface RegularPaymentPackageInterface
{
    public function isGeneral(): bool;

    /**
     * @return Collection|CustomTerm[]
     */
    public function getCategories(): Collection;

    public function getCategoryIds(): array;

    public function getNumber(): int;

    public function getExpire(): int;

    public function getFeaturedExpire(): int;

    public function getPrice(): float;

    public function getDisplayPrice(): string;

    public function getLabel(): string;

    public function getName(): string;

    public function isRegularPackage(): bool;

    public function getUserAccountType(): string;
}