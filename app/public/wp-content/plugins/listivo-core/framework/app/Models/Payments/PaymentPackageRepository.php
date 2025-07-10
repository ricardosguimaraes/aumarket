<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\User\User;

class PaymentPackageRepository
{
    private function filterByUser(Collection $packages, User $user): Collection
    {
        return $packages->filter(static function ($package) use ($user) {
            /* @var BasePaymentPackage $package */
            return $package->isUserValid($user);
        });
    }

    private function filterByCategory(Collection $packages, Model $model): Collection
    {
        $mainCategory = tdf_settings()->getMainCategory();
        if (!$mainCategory) {
            return $packages;
        }

        return $packages->filter(static function ($paymentPackage) use ($model, $mainCategory) {
            /* @var PaymentPackage $paymentPackage */
            if ($paymentPackage->isGeneral()) {
                return true;
            }

            $categoryIds = $paymentPackage->getCategoryIds();

            foreach ($mainCategory->getValue($model) as $term) {
                if (in_array($term->getId(), $categoryIds, true)) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * @return Collection|PaymentPackage[]
     */
    public function getRegularPaymentPackages(): Collection
    {
        return tdf_payment_packages();
    }

    public function getRegularPaymentPackagesForUser(User $user): Collection
    {
        return $this->filterByUser($this->getRegularPaymentPackages(), $user);
    }

    /**
     * @param  User  $user
     * @param  Model  $model
     * @return Collection|PaymentPackage[]
     */
    public function getRegularPaymentPackagesForModel(User $user, Model $model): Collection
    {
        return $this->filterByCategory($this->filterByUser($this->getRegularPaymentPackages(), $user), $model);
    }

    /**
     * @return Collection|BumpPaymentPackage[]
     */
    public function getBumpPaymentPackages(): Collection
    {
        return tdf_bumps_payment_packages();
    }

    /**
     * @param  User  $user
     * @param  Model  $model
     * @return Collection|BumpPaymentPackage[]
     */
    public function getBumpUpPaymentPackagesForModel(User $user, Model $model): Collection
    {
        return $this->filterByCategory($this->filterByUser($this->getBumpPaymentPackages(), $user), $model);
    }
}