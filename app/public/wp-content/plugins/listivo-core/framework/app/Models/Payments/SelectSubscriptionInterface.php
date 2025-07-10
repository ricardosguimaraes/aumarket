<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Core\Collection;

interface SelectSubscriptionInterface
{
    public function getKey(): string;

    public function isGeneral(): bool;

    public function getCategories(): Collection;

    public function getCategoryIds(): array;

    public function getNumber(): int;

    public function getExpire(): int;

    public function getFeaturedExpire(): int;

    public function getPrice(): float;

    public function getDisplayPrice(): string;

    public function getLabel(): string;

    public function getName(): string;

    public function getBumpsNumber(): int;

    public function getBumpsInterval(): int;

    public function isFeatured(): bool;

    public function getText(): string;
}