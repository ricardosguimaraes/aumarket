<?php

namespace Tangibledesign\Framework\Actions\PaymentPackage;

use Tangibledesign\Framework\Models\Payments\BaseUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpPaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpUserPaymentPackage;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\User\User;

class CreateBumpUserPaymentPackageAction
{

    public static function create(User $user, BumpPaymentPackage $paymentPackage): ?BumpUserPaymentPackage
    {
        $packageId = wp_insert_post([
            'post_author' => $user->getId(),
            'post_title' => $paymentPackage->getName(),
            'post_type' => tdf_prefix().'_user_package',
            'post_status' => PostStatus::PUBLISH,
            'meta_input' => [
                BaseUserPaymentPackage::TYPE => BaseUserPaymentPackage::TYPE_BUMP,
                BaseUserPaymentPackage::PAYMENT_PACKAGE => $paymentPackage->getId(),
                BaseUserPaymentPackage::DISPLAY_PRICE => $paymentPackage->getDisplayPrice(),
                BumpUserPaymentPackage::BUMPS_NUMBER => $paymentPackage->getBumpsNumber(),
                BaseUserPaymentPackage::CATEGORIES => $paymentPackage->getCategoryIds(),
                BaseUserPaymentPackage::USER_ACCOUNT_TYPE => $paymentPackage->getUserAccountType(),
            ]
        ]);

        if (is_wp_error($packageId)) {
            return null;
        }

        $package = tdf_post_factory()->create($packageId);
        if (!$package instanceof BumpUserPaymentPackage) {
            return null;
        }

        return $package;
    }

}