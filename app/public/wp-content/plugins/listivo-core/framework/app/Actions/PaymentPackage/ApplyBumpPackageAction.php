<?php

namespace Tangibledesign\Framework\Actions\PaymentPackage;

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Payments\BumpUserPaymentPackage;

class ApplyBumpPackageAction
{
    /**
     * @param BumpUserPaymentPackage $userPaymentPackage
     * @param Model $model
     * @return bool
     */
    public function apply(BumpUserPaymentPackage $userPaymentPackage, Model $model): bool
    {
        if ($userPaymentPackage->getBumpsNumber() <= 0) {
            return false;
        }

        $model->bump();

        $userPaymentPackage->decreaseBumpsNumber();

        return true;
    }

}