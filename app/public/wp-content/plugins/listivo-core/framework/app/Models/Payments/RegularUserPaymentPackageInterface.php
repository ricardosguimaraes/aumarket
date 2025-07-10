<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Term\CustomTerm;

interface RegularUserPaymentPackageInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return int
     */
    public function getNumber(): int;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @return int
     */
    public function getExpire(): int;

    /**
     * @return int
     */
    public function getFeaturedExpire(): int;

    /**
     * @return bool
     */
    public function isGeneral(): bool;

    /**
     * @return Collection|CustomTerm[]
     */
    public function getCategories(): Collection;

    /**
     * @return array
     */
    public function getCategoryIds(): array;

    /**
     * @param Model $model
     * @param TaxonomyField $mainCategory
     * @return bool
     */
    public function verify(Model $model, TaxonomyField $mainCategory): bool;

    /**
     * @return int
     */
    public function getBumpsNumber(): int;

    /**
     * @return int
     */
    public function getBumpsInterval(): int;

}