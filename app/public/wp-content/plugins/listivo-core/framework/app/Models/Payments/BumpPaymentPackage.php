<?php

namespace Tangibledesign\Framework\Models\Payments;

use JsonSerializable;
use Tangibledesign\Framework\Actions\PaymentPackage\CreateBumpUserPaymentPackageAction;
use Tangibledesign\Framework\Models\User\User;

class BumpPaymentPackage extends BasePaymentPackage implements JsonSerializable
{
    public const BUMPS_NUMBER = 'bumps_number';

    /**
     * @param  int  $number
     * @return void
     */
    public function setBumpsNumber(int $number): void
    {
        $this->setMeta(self::BUMPS_NUMBER, $number);
    }

    /**
     * @return int
     */
    public function getBumpsNumber(): int
    {
        return (int)$this->getMeta(self::BUMPS_NUMBER);
    }

    /**
     * @param  array  $data
     */
    public function setData(array $data): void
    {
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

        if (isset($data[self::BUMPS_NUMBER])) {
            $this->setBumpsNumber((int)$data[self::BUMPS_NUMBER]);
        }

        if (isset($data[self::TEXT])) {
            $this->setText($data[self::TEXT]);
        }

        if (isset($data[self::USER_ACCOUNT_TYPE])) {
            $this->setUserAccountType($data[self::USER_ACCOUNT_TYPE]);
        }

        if (isset($data[self::CATEGORIES])) {
            $this->setCategories($data[self::CATEGORIES]);
        }

        $this->setFeatured((int)($data[self::FEATURED] ?? 0));
    }

    /**
     * @return array
     */
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
            'bumpsNumber' => $this->getBumpsNumber(),
            'categoryIds' => $this->getCategoryIds(),
            'text' => $this->getText(),
            'isFeatured' => $this->isFeatured(),
            'userAccountType' => $this->getUserAccountType(),
            'userAccountTypeLabel' => $this->getUserAccountTypeLabel(),
        ];
    }

    public function createUserPaymentPackage(User $user): ?BumpUserPaymentPackage
    {
        return CreateBumpUserPaymentPackageAction::create($user, $this);
    }

    public function setDefaultData(): void
    {
        $this->setDisplayPrice('$5');

        $this->setPrice(5);

        $this->setBumpsNumber(1);
    }

}