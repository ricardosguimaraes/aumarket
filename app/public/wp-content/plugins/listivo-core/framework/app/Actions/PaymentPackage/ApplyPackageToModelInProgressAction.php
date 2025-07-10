<?php

namespace Tangibledesign\Framework\Actions\PaymentPackage;

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Payments\UserPaymentPackageInterface;

class ApplyPackageToModelInProgressAction
{

    public function execute(Model $model, UserPaymentPackageInterface $userPaymentPackage): void
    {
        if (
            $model->isPublished()
            || !tdf_settings()->moderationEnabled()
            || ($model->isApproved() && !tdf_settings()->moderationRequiredReApprove())
        ) {
            $this->publish($model, $userPaymentPackage);
            return;
        }

        $this->pending($model, $userPaymentPackage);
    }

    public function publish(Model $model, UserPaymentPackageInterface $userPaymentPackage): void
    {
        if (!$userPaymentPackage->apply($model)) {
            return;
        }

        if (!$model->isPublished()) {
            $model->setPublish();
        }
    }

    public function pending(Model $model, UserPaymentPackageInterface $userPaymentPackage): void
    {
        $model->setPendingPackage($userPaymentPackage->getId());

        $model->setPending();

        $userPaymentPackage->decrease();

        do_action(tdf_prefix().'/notifications/trigger', Trigger::USER_MODEL_PENDING, [
            'user' => $model->getUserId(),
            'model' => $model->getId(),
        ]);

        do_action(tdf_prefix().'/notifications/trigger', Trigger::MODERATION_MODEL_PENDING, [
            'user' => $model->getUserId(),
            'model' => $model->getId(),
        ]);
    }

}