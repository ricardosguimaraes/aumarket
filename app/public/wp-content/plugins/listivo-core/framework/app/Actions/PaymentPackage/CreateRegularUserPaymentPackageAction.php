<?php

namespace Tangibledesign\Framework\Actions\PaymentPackage;

use Tangibledesign\Framework\Models\Payments\BaseUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\RegularPaymentPackageInterface;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackageInterface;
use Tangibledesign\Framework\Models\Payments\SubscriptionInterface;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\User\User;

class CreateRegularUserPaymentPackageAction
{
    public function execute(
        User                           $user,
        RegularPaymentPackageInterface $paymentPackage
    ): ?RegularUserPaymentPackageInterface
    {
        $packageId = wp_insert_post([
            'post_author' => $user->getId(),
            'post_title' => $paymentPackage->getName(),
            'post_type' => tdf_prefix() . '_user_package',
            'post_status' => PostStatus::PUBLISH,
            'meta_input' => [
                BaseUserPaymentPackage::TYPE => BaseUserPaymentPackage::TYPE_REGULAR,
                BaseUserPaymentPackage::PAYMENT_PACKAGE => $paymentPackage->getId(),
                BaseUserPaymentPackage::DISPLAY_PRICE => $paymentPackage->getDisplayPrice(),
                BaseUserPaymentPackage::CATEGORIES => $paymentPackage->getCategoryIds(),
                BaseUserPaymentPackage::USER_ACCOUNT_TYPE => $paymentPackage->getUserAccountType(),
                RegularUserPaymentPackage::SOURCE_TYPE => $this->getSourceType($paymentPackage),
                RegularUserPaymentPackage::NUMBER => $paymentPackage->getNumber(),
                RegularUserPaymentPackage::EXPIRE => $paymentPackage->getExpire(),
                RegularUserPaymentPackage::FEATURED_EXPIRE => $paymentPackage->getFeaturedExpire(),
                RegularUserPaymentPackage::BUMPS_NUMBER => $paymentPackage->getBumpsNumber(),
                RegularUserPaymentPackage::BUMPS_INTERVAL => $paymentPackage->getBumpsInterval(),
            ]
        ]);

        if (is_wp_error($packageId)) {
            return null;
        }

        $userPaymentPackage = tdf_post_factory()->create($packageId);
        if (!$userPaymentPackage instanceof RegularUserPaymentPackage) {
            return null;
        }

        return $userPaymentPackage;
    }

    private function getSourceType(RegularPaymentPackageInterface $paymentPackage): string
    {
        if (($paymentPackage instanceof SubscriptionInterface)) {
            return RegularUserPaymentPackage::SOURCE_TYPE_SUBSCRIPTION;
        }

        return RegularUserPaymentPackage::SOURCE_TYPE_PAYMENT_PACKAGE;
    }
}