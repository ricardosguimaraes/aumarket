<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\User\User;

class UserPaymentPackageRepository
{
    /**
     * @return Collection|BaseUserPaymentPackage[]
     */
    private function filterByCategory(Collection $packages, Model $model): Collection
    {
        $mainCategory = tdf_settings()->getMainCategory();
        if (!$mainCategory) {
            return $packages;
        }

        return $packages->filter(static function ($paymentPackage) use ($model, $mainCategory) {
            /* @var BaseUserPaymentPackage $paymentPackage */
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
     * @param  User  $user
     * @return Collection|RegularUserPaymentPackage[]
     */
    public function getRegularPaymentPackages(User $user): Collection
    {
        return $user->getPaymentPackages();
    }

    /**
     * @param  User  $user
     * @return Collection|RegularUserPaymentPackage[]
     */
    public function getNotEmptyRegularPaymentPackages(User $user): Collection
    {
        return $this->getRegularPaymentPackages($user)->filter(static function ($package) {
            /* @var RegularUserPaymentPackage $package */
            return $package->getNumber() > 0;
        });
    }

    /**
     * @param  User  $user
     * @param  Model  $model
     * @return Collection|RegularUserPaymentPackage[]
     */
    public function getRegularPaymentPackagesForModel(User $user, Model $model): Collection
    {
        $mainCategory = tdf_settings()->getMainCategory();
        if (!$mainCategory) {
            return $this->getNotEmptyRegularPaymentPackages($user);
        }

        return $this->filterByCategory($this->getNotEmptyRegularPaymentPackages($user), $model);
    }

    /**
     * @param  User  $user
     * @return Collection|BumpUserPaymentPackage[]
     */
    public function getBumpPaymentPackages(User $user): Collection
    {
        return $user->getBumpPaymentPackages();
    }

    /**
     * @param  User  $user
     * @return Collection|BumpUserPaymentPackage[]
     */
    public function getNotEmptyBumpPaymentPackages(User $user): Collection
    {
        return $this->getBumpPaymentPackages($user)->filter(static function ($package) {
            /* @var BumpUserPaymentPackage $package */
            return $package->getBumpsNumber() > 0;
        });
    }

    /**
     * @param  User  $user
     * @param  Model  $model
     * @return Collection|BumpUserPaymentPackage[]
     */
    public function getBumpPaymentPackagesForModel(User $user, Model $model): Collection
    {
        return $this->filterByCategory($this->getNotEmptyBumpPaymentPackages($user), $model);
    }

}