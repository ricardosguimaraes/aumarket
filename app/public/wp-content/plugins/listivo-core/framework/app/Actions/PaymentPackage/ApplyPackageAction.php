<?php


namespace Tangibledesign\Framework\Actions\PaymentPackage;


use DateTime;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackageInterface;

class ApplyPackageAction
{
    /**
     * @param  RegularUserPaymentPackageInterface  $userPaymentPackage
     * @param  Model  $model
     * @param  bool  $decreasePackage
     * @return bool
     */
    public function apply(
        RegularUserPaymentPackageInterface $userPaymentPackage,
        Model $model,
        bool $decreasePackage = true
    ): bool {
        if ($decreasePackage && $userPaymentPackage->getNumber() <= 0) {
            return false;
        }

        $mainCategory = tdf_settings()->getMainCategory();
        if ($mainCategory && !$userPaymentPackage->verify($model, $mainCategory)) {
            return false;
        }

        $this->setExpireDate($userPaymentPackage, $model);

        $this->setExpireFeaturedDate($userPaymentPackage, $model);

        if (!empty($userPaymentPackage->getBumpsNumber())) {
            $this->setBumpDates($userPaymentPackage, $model);
        }

        $model->assignPackage($userPaymentPackage->getId());

        if ($decreasePackage) {
            $model->getUser()->decreasePackage($userPaymentPackage->getId());
        }

        $model->clearExpireNotifications();

        return true;
    }

    /**
     * @param  RegularUserPaymentPackageInterface  $package
     * @param  Model  $model
     * @return void
     */
    private function setBumpDates(RegularUserPaymentPackageInterface $package, Model $model): void
    {
        $date = new DateTime();
        $dates = [];

        for ($i = 0; $i < $package->getBumpsNumber(); $i++) {
            $date->modify('+'.$package->getBumpsInterval().' days');

            $dates[] = $date->format('Y-m-d H:i:s');
        }

        $model->setBumpDates($dates);

        $model->setNextBumpDate($model->shiftBumpDates());
    }

    /**
     * @param  RegularUserPaymentPackageInterface  $package
     * @param  Model  $model
     */
    private function setExpireDate(RegularUserPaymentPackageInterface $package, Model $model): void
    {
        $expireDays = $package->getExpire();
        if ($expireDays <= 0) {
            $model->setExpireDate('unlimited');
            return;
        }

        $date = new DateTime();

        if ($model->hasExpireDate()) {
            $date->setTimestamp(strtotime($model->getExpireDate()));
        }

        $date->modify('+'.$expireDays.' days');

        $model->setExpireDate($date->format('Y-m-d H:i:s'));
    }

    /**
     * @param  RegularUserPaymentPackageInterface  $package
     * @param  Model  $model
     */
    private function setExpireFeaturedDate(RegularUserPaymentPackageInterface $package, Model $model): void
    {
        $featuredExpireDays = $package->getFeaturedExpire();
        if ($featuredExpireDays <= 0) {
            return;
        }

        $date = new DateTime();

        if ($model->hasFeaturedExpireDate()) {
            $date->setTimestamp(strtotime($model->getFeaturedExpireDate()));
        }

        $date->modify('+'.$featuredExpireDays.' days');

        $model->setFeatured(1);

        $model->setFeaturedExpireDate($date->format('Y-m-d H:i:s'));
    }

}