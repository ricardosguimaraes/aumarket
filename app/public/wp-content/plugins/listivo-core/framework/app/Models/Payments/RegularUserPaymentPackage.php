<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Actions\PaymentPackage\ApplyPackageAction;
use Tangibledesign\Framework\Models\Model;

class RegularUserPaymentPackage extends BaseUserPaymentPackage implements RegularUserPaymentPackageInterface
{
    public const NUMBER = 'number';
    public const EXPIRE = 'expire';
    public const FEATURED_EXPIRE = 'featured_expire';
    public const BUMPS_NUMBER = 'bumps_number';
    public const BUMPS_INTERVAL = 'bumps_interval';
    public const SOURCE_TYPE = 'source_type';
    public const SOURCE_TYPE_SUBSCRIPTION = 'subscription';
    public const SOURCE_TYPE_PAYMENT_PACKAGE = 'payment_package';
    public const EXPIRE_DATE = 'expire_date';

    public function setExpireDate(int $date): void
    {
        $this->setMeta(self::EXPIRE_DATE, $date);
    }

    public function getExpireDate(): string
    {
        $timestamp = (int)$this->getMeta(self::EXPIRE_DATE);
        if (!empty($timestamp)) {
            return date_i18n(get_option('date_format'), $timestamp);
        }

        if ($this->getSourceType() === self::PAYMENT_PACKAGE) {
            return '';
        }

        $user = $this->getUser();
        if (!$user) {
            return '';
        }

        $subscription = $user->getUserSubscription();
        if (!$subscription) {
            return '';
        }

        $currentPeriodEnd = $subscription->getCurrentPeriodEnd();
        if (!$currentPeriodEnd) {
            return '';
        }

        return $currentPeriodEnd->format(get_option('date_format'));
    }

    public function setBumpsNumber(int $number): void
    {
        $this->setMeta(self::BUMPS_NUMBER, $number);
    }

    public function getBumpsNumber(): int
    {
        return (int)$this->getMeta(self::BUMPS_NUMBER);
    }

    public function setBumpsInterval(int $interval): void
    {
        $this->setMeta(self::BUMPS_INTERVAL, $interval);
    }

    public function getBumpsInterval(): int
    {
        return (int)$this->getMeta(self::BUMPS_INTERVAL);
    }

    /**
     * @param int $number
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setNumber($number): void
    {
        $this->setMeta(self::NUMBER, (int)$number);
    }

    public function decreaseNumber(): void
    {
        $this->setNumber($this->getNumber() - 1);
    }

    public function decrease(): void
    {
        $this->decreaseNumber();
    }

    public function increaseNumber(): void
    {
        $this->setNumber($this->getNumber() + 1);
    }

    public function getNumber(): int
    {
        $number = (int)$this->getMeta(self::NUMBER);
        if ($number < 0) {
            return 0;
        }

        return $number;
    }

    public function isEmpty(): bool
    {
        return empty($this->getNumber());
    }

    public function getExpire(): int
    {
        return $this->getMeta(self::EXPIRE);
    }

    public function getFeaturedExpire(): int
    {
        return $this->getMeta(self::FEATURED_EXPIRE);
    }

    public function jsonSerialize(): array
    {
        return [
            'key' => $this->getKey(),
            'name' => $this->getName(),
            self::NUMBER => $this->getNumber(),
            self::EXPIRE => $this->getExpire(),
            self::FEATURED_EXPIRE => $this->getFeaturedExpire(),
            self::BUMPS_NUMBER => $this->getBumpsNumber(),
            self::BUMPS_INTERVAL => $this->getBumpsInterval(),
        ];
    }

    public function apply(Model $model): bool
    {
        return (new ApplyPackageAction())->apply($this, $model);
    }

    public function getSourceType(): string
    {
        $sourceType = (string)$this->getMeta(self::SOURCE_TYPE);
        if (empty($sourceType)) {
            return self::PAYMENT_PACKAGE;
        }

        return $sourceType;
    }
}