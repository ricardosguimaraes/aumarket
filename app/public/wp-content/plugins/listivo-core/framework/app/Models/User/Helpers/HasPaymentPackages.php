<?php

namespace Tangibledesign\Framework\Models\User\Helpers;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Payments\BumpUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackageInterface;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\UserPaymentPackageInterface;

trait HasPaymentPackages
{
    abstract public function getId(): int;

    /**
     * @return Collection|BumpUserPaymentPackage[]
     */
    public function getBumpPaymentPackages(): Collection
    {
        return tdf_query_user_payment_packages()
            ->userIn($this->getId())
            ->bumpType()
            ->get();
    }

    /**
     * @return BumpUserPaymentPackage|false
     */
    public function getNotEmptyBumpUpPackage()
    {
        return $this->getBumpPaymentPackages()->find(static function ($userPaymentPackage) {
            return $userPaymentPackage instanceof BumpUserPaymentPackage && !$userPaymentPackage->isEmpty();
        });
    }

    /**
     * @return Collection|RegularUserPaymentPackage[]
     */
    public function getPaymentPackages(): Collection
    {
        return tdf_query_user_payment_packages()
            ->userIn($this->getId())
            ->regularType()
            ->get();
    }

    /**
     * @return Collection|RegularUserPaymentPackage[]
     */
    public function getNotEmptyPackages(): Collection
    {
        return $this->getPaymentPackages()
            ->filter(static function ($userPaymentPackage) {
                /* @var RegularUserPaymentPackage $userPaymentPackage */
                return !$userPaymentPackage->isEmpty();
            });
    }

    /**
     * @param Model $model
     * @return Collection|RegularUserPaymentPackage[]
     */
    public function getPackagesForModel(Model $model): Collection
    {
        $mainCategory = tdf_settings()->getMainCategory();
        $packages = $this->getNotEmptyPackages();

        if (!$mainCategory) {
            return $packages;
        }

        return $packages->filter(static function ($package) use ($model, $mainCategory) {
            /* @var RegularUserPaymentPackage $package */
            return $package->verify($model, $mainCategory) && $package->getNumber() > 0;
        });
    }

    public function getPromotePackagesForModel(Model $model): Collection
    {
        return $this->getPackagesForModel($model)
            ->filter(static function (RegularUserPaymentPackage $userPaymentPackage) {
                return $userPaymentPackage->getFeaturedExpire() > 0;
            });
    }

    public function addPaymentPackage(PaymentPackageInterface $paymentPackage): ?UserPaymentPackageInterface
    {
        return $paymentPackage->createUserPaymentPackage($this);
    }

    /**
     * @param int $userPaymentPackageId
     *
     * @return RegularUserPaymentPackage|false
     * @noinspection PhpMissingParamTypeInspection
     */
    public function getPaymentPackage($userPaymentPackageId)
    {
        $userPaymentPackage = tdf_query_user_payment_packages()
            ->userIn($this->getId())
            ->in((int)$userPaymentPackageId)
            ->get()
            ->first();

        if (!$userPaymentPackage instanceof RegularUserPaymentPackage) {
            return false;
        }

        return $userPaymentPackage;
    }

    public function decreasePackage(int $userPaymentPackageId): bool
    {
        $package = $this->getPaymentPackage($userPaymentPackageId);
        if (!$package) {
            return false;
        }

        $package->decreaseNumber();

        return true;
    }

    /**
     * @param int $userPaymentPackageId
     * @return bool
     */
    public function increasePackage(int $userPaymentPackageId): bool
    {
        $package = $this->getPaymentPackage($userPaymentPackageId);
        if (!$package) {
            return false;
        }

        $package->increaseNumber();

        return true;
    }

    public function hasPackages(): bool
    {
        return $this->getNotEmptyPackages()->isNotEmpty();
    }

    public function getBumpsNumber(): int
    {
        $number = 0;

        foreach ($this->getBumpPaymentPackages() as $package) {
            $number += $package->getBumpsNumber();
        }

        return $number;
    }

    public function getAllPackages(): Collection
    {
        return $this->getPaymentPackages()
            ->merge($this->getBumpPaymentPackages());
    }

    public function getAllNotEmptyPackages(): Collection
    {
        return $this->getNotEmptyPackages()
            ->merge($this->getNotEmptyBumpUpPackage());
    }
}