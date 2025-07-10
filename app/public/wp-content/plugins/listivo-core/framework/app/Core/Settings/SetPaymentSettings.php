<?php

namespace Tangibledesign\Framework\Core\Settings;

use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpPaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackage;
use Tangibledesign\Framework\Models\Payments\SavePaymentPackage;

trait SetPaymentSettings
{
    use Setting;

    public function setEnablePayments($enable): void
    {
        $this->setSetting(SettingKey::ENABLE_PAYMENTS, (int)$enable);
    }

    public function paymentsEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_PAYMENTS));
    }

    public function setEnableBumps($enable): void
    {
        $this->setSetting(SettingKey::ENABLE_BUMPS, (int)$enable);
    }

    public function bumpsEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_BUMPS));
    }


    public function setEnableFreeListing($enableFreeListing): void
    {
        $this->setSetting(SettingKey::ENABLE_FREE_LISTING, (int)$enableFreeListing);
    }

    public function isFreeListingEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_FREE_LISTING));
    }

    public function setFreeListingLabel(?string $label): void
    {
        $this->setSetting(SettingKey::FREE_LISTING_LABEL, (string)$label);
    }

    public function getFreeListingLabel(): string
    {
        return (string)$this->getSetting(SettingKey::FREE_LISTING_LABEL);
    }

    public function setFreeListingText(?string $text): void
    {
        $this->setSetting(SettingKey::FREE_LISTING_TEXT, (string)$text);
    }

    public function getFreeListingText(): string
    {
        return (string)$this->getSetting(SettingKey::FREE_LISTING_TEXT);
    }

    public function setFreeListingExpire($days): void
    {
        $this->setSetting(SettingKey::FREE_LISTING_EXPIRE, (int)$days);
    }

    public function getFreeListingExpire(): int
    {
        return (int)$this->getSetting(SettingKey::FREE_LISTING_EXPIRE);
    }

    public function setFreeListingFeaturedExpire($days): void
    {
        $this->setSetting(SettingKey::FREE_LISTING_FEATURED_EXPIRE, (int)$days);
    }

    public function getFreeListingFeaturedExpire(): int
    {
        return (int)$this->getSetting(SettingKey::FREE_LISTING_FEATURED_EXPIRE);
    }

    public function setFreeListingBumpsNumber($number): void
    {
        $this->setSetting(SettingKey::FREE_LISTING_BUMPS_NUMBER, (int)$number);
    }

    public function getFreeListingBumpsNumber(): int
    {
        return (int)$this->getSetting(SettingKey::FREE_LISTING_BUMPS_NUMBER);
    }

    public function setFreeListingBumpsInterval($number): void
    {
        $this->setSetting(SettingKey::FREE_LISTING_BUMPS_INTERVAL, (int)$number);
    }

    public function getFreeListingBumpsInterval(): int
    {
        return (int)$this->getSetting(SettingKey::FREE_LISTING_BUMPS_INTERVAL);
    }

    public function setEnableRegisterPackage($enable): void
    {
        $this->setSetting(SettingKey::ENABLE_REGISTER_PACKAGE, (int)$enable);
    }

    public function isRegisterPackageEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_REGISTER_PACKAGE));
    }

    public function setRegisterPackageNumber($number): void
    {
        $this->setSetting(SettingKey::REGISTER_PACKAGE_NUMBER, (int)$number);
    }

    public function getRegisterPackageNumber(): int
    {
        return (int)$this->getSetting(SettingKey::REGISTER_PACKAGE_NUMBER);
    }

    public function setRegisterPackageExpire($days): void
    {
        $this->setSetting(SettingKey::REGISTER_PACKAGE_EXPIRE, (int)$days);
    }

    public function getRegisterPackageExpire(): int
    {
        return (int)$this->getSetting(SettingKey::REGISTER_PACKAGE_EXPIRE);
    }

    public function setRegisterPackageFeaturedExpire($days): void
    {
        $this->setSetting(SettingKey::REGISTER_PACKAGE_FEATURED_EXPIRE, (int)$days);
    }

    public function getRegisterPackageFeaturedExpire(): int
    {
        return (int)$this->getSetting(SettingKey::REGISTER_PACKAGE_FEATURED_EXPIRE);
    }

    public function setRegisterPackageBumpsNumber($number): void
    {
        $this->setSetting(SettingKey::REGISTER_PACKAGE_BUMPS_NUMBER, (int)$number);
    }

    public function getRegisterPackageBumpsNumber(): int
    {
        return (int)$this->getSetting(SettingKey::REGISTER_PACKAGE_BUMPS_NUMBER);
    }

    public function setRegisterPackageBumpsInterval($days): void
    {
        $this->setSetting(SettingKey::REGISTER_PACKAGE_BUMPS_INTERVAL, (int)$days);
    }

    public function getRegisterPackageBumpsInterval(): int
    {
        return (int)$this->getSetting(SettingKey::REGISTER_PACKAGE_BUMPS_INTERVAL);
    }

    public function setPaymentPackagesOrder(
        array  $paymentPackageIds,
        string $type = BasePaymentPackage::TYPE_REGULAR
    ): void
    {
        if ($type === BasePaymentPackage::TYPE_REGULAR) {
            $this->setSetting(SettingKey::PAYMENT_PACKAGES_ORDER, $paymentPackageIds);
            return;
        }

        if ($type === BasePaymentPackage::TYPE_BUMP) {
            $this->setSetting(SettingKey::BUMPS_PAYMENT_PACKAGES_ORDER, $paymentPackageIds);
        }
    }

    public function addPaymentPackage(SavePaymentPackage $package): void
    {
        if ($package instanceof BumpPaymentPackage) {
            $this->addBumpPaymentPackage($package);
        }

        if ($package instanceof PaymentPackage) {
            $this->addRegularPaymentPackage($package);
        }

        $this->save();
    }

    private function addRegularPaymentPackage(PaymentPackage $package): void
    {
        $ids = tdf_settings()->getPaymentPackageIds();
        $ids[] = $package->getId();

        $this->setPaymentPackagesOrder($ids);

        $this->save();
    }

    private function addBumpPaymentPackage(BumpPaymentPackage $package): void
    {
        $ids = tdf_settings()->getBumpsPaymentPackageIds();
        $ids[] = $package->getId();

        $this->setPaymentPackagesOrder($ids, BasePaymentPackage::TYPE_BUMP);
    }

    public function getPaymentPackageIds(): array
    {
        $ids = $this->getSetting(SettingKey::PAYMENT_PACKAGES_ORDER);

        if (empty($ids) || !is_array($ids)) {
            return [];
        }

        return tdf_collect($ids)->map(static function ($id) {
            return (int)$id;
        })->values();
    }

    public function getBumpsPaymentPackageIds(): array
    {
        $ids = $this->getSetting(SettingKey::BUMPS_PAYMENT_PACKAGES_ORDER);

        if (empty($ids) || !is_array($ids)) {
            return [];
        }

        return tdf_collect($ids)->map(static function ($id) {
            return (int)$id;
        })->values();
    }

    public function setEnableSubscriptions($enabled): void
    {
        $this->setSetting(SettingKey::ENABLE_SUBSCRIPTIONS, (int)$enabled);
    }

    public function subscriptionsEnabled(): bool
    {
        return !empty((int)$this->getSetting(SettingKey::ENABLE_SUBSCRIPTIONS));
    }

    public function setSubscriptionIds(array $ids): void
    {
        $this->setSetting(SettingKey::SUBSCRIPTIONS_ORDER, $ids);
    }

    public function getSubscriptionIds(): array
    {
        $ids = $this->getSetting(SettingKey::SUBSCRIPTIONS_ORDER);
        if (!is_array($ids)) {
            return [];
        }

        return tdf_collect($ids)
            ->map(static function ($id) {
                return (int)$id;
            })
            ->values();
    }

    public function addSubscription(int $id): void
    {
        $ids = $this->getSubscriptionIds();
        $ids[] = $id;

        $this->setSubscriptionIds($ids);

        $this->save();
    }
}