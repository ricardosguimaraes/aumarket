<?php

namespace Tangibledesign\Framework\Models\Payments;

use JsonSerializable;
use Tangibledesign\Framework\Actions\PaymentPackage\CreateRegularUserPaymentPackageAction;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Traits\Payments\HasRegularPackageAttributes;

class PaymentPackage extends BasePaymentPackage implements JsonSerializable, RegularPaymentPackageInterface
{
    use HasRegularPackageAttributes;

    public const NUMBER = 'number';
    public const EXPIRE = 'expire';
    public const FEATURED_EXPIRE = 'featured_expire';
    public const BUMPS_NUMBER = 'bumps_number';
    public const BUMPS_INTERVAL = 'bumps_interval';

    public function setData(array $data): void
    {
        if (isset($data[self::NUMBER])) {
            $this->setNumber($data[self::NUMBER]);
        }

        if (isset($data[self::EXPIRE])) {
            $this->setExpire($data[self::EXPIRE]);
        }

        if (isset($data[self::FEATURED_EXPIRE])) {
            $this->setFeaturedExpire($data[self::FEATURED_EXPIRE]);
        }

        if (isset($data[self::PRICE])) {
            $this->setPrice($data[self::PRICE]);
        }

        if (isset($data[self::DISPLAY_PRICE])) {
            $this->setDisplayPrice($data[self::DISPLAY_PRICE]);
        }

        if (isset($data[self::NAME])) {
            $this->setName($data[self::NAME]);
        }

        if (isset($data[self::LABEL])) {
            $this->setLabel($data[self::LABEL]);
        }

        if (isset($data[self::CATEGORIES])) {
            $this->setCategories($data[self::CATEGORIES]);
        }

        if (isset($data[self::BUMPS_NUMBER])) {
            $this->setBumpsNumber((int)$data[self::BUMPS_NUMBER]);
        }

        if (isset($data[self::BUMPS_INTERVAL])) {
            $this->setBumpsInterval((int)$data[self::BUMPS_INTERVAL]);
        }

        if (isset($data[self::TEXT])) {
            $this->setText($data[self::TEXT]);
        }

        if (isset($data[self::USER_ACCOUNT_TYPE])) {
            $this->setUserAccountType($data[self::USER_ACCOUNT_TYPE]);
        }

        $this->setFeatured((int)($data[self::FEATURED] ?? 0));
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'slug' => $this->getSlug(),
            'url' => $this->getUrl(),
            'label' => $this->getLabel(),
            'price' => $this->getPrice(),
            'displayPrice' => $this->getDisplayPrice(),
            'number' => $this->getNumber(),
            'expire' => $this->getExpire(),
            'featuredExpire' => $this->getFeaturedExpire(),
            'categoryIds' => $this->getCategoryIds(),
            'bumpsNumber' => $this->getBumpsNumber(),
            'bumpsInterval' => $this->getBumpsInterval(),
            'text' => $this->getText(),
            'isFeatured' => $this->isFeatured(),
            'userAccountType' => $this->getUserAccountType(),
            'userAccountTypeLabel' => $this->getUserAccountTypeLabel(),
        ];
    }

    public function createUserPaymentPackage(User $user): RegularUserPaymentPackageInterface
    {
        return (new CreateRegularUserPaymentPackageAction())->execute($user, $this);
    }

    public function setDefaultData(): void
    {
        $this->setDisplayPrice('$10');

        $this->setPrice('10');

        $this->setNumber(1);

        $this->setExpire(14);

        $this->setFeaturedExpire(0);

        $this->setBumpsNumber(1);

        $this->setBumpsInterval(7);

        $this->setUserAccountType('any');
    }
}