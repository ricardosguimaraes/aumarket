<?php

namespace Tangibledesign\Framework\Models\Payments;

use JsonSerializable;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Post\Post;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Models\User\User;

abstract class BaseUserPaymentPackage extends Post implements UserPaymentPackageInterface, JsonSerializable
{
    public const TYPE = 'type';
    public const TYPE_REGULAR = 'regular';
    public const TYPE_BUMP = 'bump';
    public const DISPLAY_PRICE = 'display_price';
    public const PAYMENT_PACKAGE = 'payment_package';
    public const ORDER = 'order';
    public const CATEGORIES = 'categories';
    public const USER_ACCOUNT_TYPE = 'user_account_type';

    public function getEditUrl(): string
    {
        return admin_url('admin.php?page=tdf-user-payment-packages-edit&id=' . $this->getId());
    }

    public function getDisplayPrice(): string
    {
        return (string)$this->getMeta(self::DISPLAY_PRICE);
    }

    /**
     * @param int $paymentPackageId
     * @return void
     */
    public function setPaymentPackage($paymentPackageId): void
    {
        $this->setMeta(self::PAYMENT_PACKAGE, (int)$paymentPackageId);
    }

    public function getPaymentPackageId(): int
    {
        return (int)$this->getMeta(self::PAYMENT_PACKAGE);
    }

    /**
     * @return PaymentPackageInterface|false
     */
    public function getPaymentPackage()
    {
        $paymentPackageId = $this->getPaymentPackageId();
        if (empty($paymentPackageId)) {
            return false;
        }

        $paymentPackage = tdf_post_factory()->create($paymentPackageId);
        if (!$paymentPackage instanceof PaymentPackageInterface) {
            return false;
        }

        return $paymentPackage;
    }

    public function assignOrder(int $orderId): void
    {
        $this->setMeta(self::ORDER, $orderId);
    }


    public function isGeneral(): bool
    {
        if (!tdf_settings()->getMainCategory()) {
            return true;
        }

        return $this->getCategories()->isEmpty();
    }

    /**
     * @return Collection|CustomTerm[]
     */
    public function getCategories(): Collection
    {
        if (!tdf_settings()->getMainCategory()) {
            return tdf_collect();
        }

        $categoryIds = $this->getCategoryIds();
        if (empty($categoryIds)) {
            return tdf_collect();
        }

        return tdf_query_terms(tdf_settings()
            ->getMainCategory()->getKey())
            ->in($categoryIds)
            ->get();
    }

    public function getCategoryIds(): array
    {
        $categoryIds = $this->getMeta(self::CATEGORIES);
        if (empty($categoryIds) || !is_array($categoryIds)) {
            return [];
        }

        return tdf_collect($categoryIds)
            ->map(static function ($categoryId) {
                return (int)$categoryId;
            })->values();
    }

    public function verify(Model $model, TaxonomyField $mainCategory): bool
    {
        $user = $model->getUser();
        if (!$user instanceof User) {
            return false;
        }

        $accountType = $this->getUserAccountType();
        if ($accountType !== 'any' && $user->getAccountType() !== $accountType) {
            return false;
        }

        if ($this->isGeneral()) {
            return true;
        }

        foreach ($mainCategory->getValue($model) as $term) {
            if (in_array($term->getId(), $this->getCategoryIds(), true)) {
                return true;
            }
        }

        return false;
    }

    public function getUserAccountType(): string
    {
        $accountType = $this->getMeta(self::USER_ACCOUNT_TYPE);
        if (empty($accountType)) {
            return 'any';
        }

        return $accountType;
    }

}