<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\CurrentUserCan;
use Tangibledesign\Framework\Helpers\VerifyNonce;
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackageInterface;
use Tangibledesign\Framework\Models\Payments\PaymentPackageRepository;
use Tangibledesign\Framework\Models\Payments\SavePaymentPackage;
use Tangibledesign\Framework\Models\Payments\UserPaymentPackageRepository;
use Tangibledesign\Framework\Models\Post\PostStatus;

class PaymentPackagesServiceProvider extends ServiceProvider
{
    use VerifyNonce;
    use CurrentUserCan;

    public function initiation(): void
    {
        $this->container['payment_packages'] = static function () {
            if (empty(tdf_settings()->getPaymentPackageIds())) {
                return tdf_collect();
            }

            $packages = tdf_query_payment_packages()
                ->in(tdf_settings()->getPaymentPackageIds())
                ->get();

            return tdf_collect(tdf_settings()->getPaymentPackageIds())->map(static function ($packageId) use ($packages
            ) {
                return $packages->find(static function ($package) use ($packageId) {
                    /* @var PaymentPackageInterface $package */
                    return $package->getId() === $packageId;
                });
            })->filter(static function ($package) {
                return $package !== false;
            })->toValues();
        };

        $this->container['bumps_payment_packages'] = static function () {
            if (empty(tdf_settings()->getBumpsPaymentPackageIds())) {
                return tdf_collect();
            }

            $packages = tdf_query_payment_packages()
                ->in(tdf_settings()->getBumpsPaymentPackageIds())
                ->get();

            return tdf_collect(tdf_settings()->getBumpsPaymentPackageIds())->map(static function ($packageId) use (
                $packages
            ) {
                return $packages->find(static function ($package) use ($packageId) {
                    /* @var PaymentPackageInterface $package */
                    return $package->getId() === $packageId;
                });
            })->filter(static function ($package) {
                return $package !== false;
            })->toValues();
        };

        $this->container['payment_package_repository'] = static function () {
            return new PaymentPackageRepository();
        };

        $this->container['user_payment_package_repository'] = static function () {
            return new UserPaymentPackageRepository();
        };
    }

    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/paymentPackage/create', [$this, 'create']);
        add_action('admin_post_'.tdf_prefix().'/paymentPackage/delete', [$this, 'delete']);
        add_action('admin_post_'.tdf_prefix().'/paymentPackage/update', [$this, 'update']);
        add_action('admin_post_'.tdf_prefix().'/paymentPackages/updateOrder', [$this, 'updateOrder']);
    }

    public function updateOrder(): void
    {
        if (!isset($_POST['paymentPackageIds']) || !current_user_can('manage_options')) {
            return;
        }

        tdf_settings()->setPaymentPackagesOrder($_POST['paymentPackageIds'],
            $_POST['type'] ?? BasePaymentPackage::TYPE_REGULAR);

        tdf_settings()->save();
    }

    public function update(): void
    {
        if (!$this->verifyNonce($_POST['nonce'], tdf_prefix().'/paymentPackage/update')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $packageId = (int)($_POST['packageId'] ?? 0);
        if (empty($packageId)) {
            return;
        }

        $package = tdf_post_factory()->create($packageId);
        if (!$package instanceof SavePaymentPackage) {
            return;
        }

        $package->setData($_POST['package'] ?? []);

        do_action(tdf_prefix().'/paymentPackages/synchronize');

        wp_safe_redirect(admin_url('admin.php?page='.tdf_prefix().'_monetization&tab=packages&package_type='.$package->getType()));
        exit;
    }

    public function delete(): void
    {
        if (!isset($_POST['packageId']) || !current_user_can('manage_options')) {
            return;
        }

        wp_delete_post((int)$_POST['packageId'], true);

        do_action(tdf_prefix().'/paymentPackages/synchronize');
    }

    public function create(): void
    {
        if (!$this->verifyNonce($_POST['nonce'] ?? '', tdf_prefix().'/paymentPackage/create')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $name = $_POST[BasePaymentPackage::NAME] ?? 'New Package';
        $type = $_POST[BasePaymentPackage::TYPE] ?? BasePaymentPackage::TYPE_REGULAR;

        $packageId = wp_insert_post([
            'post_title' => $name,
            'post_status' => PostStatus::PUBLISH,
            'post_type' => tdf_prefix().'_package',
            'meta_input' => [
                BasePaymentPackage::TYPE => $type,
            ]
        ]);

        if (!is_int($packageId)) {
            return;
        }

        $package = tdf_post_factory()->create($packageId);
        if (!$package instanceof SavePaymentPackage) {
            return;
        }

        $package->setDefaultData();

        tdf_settings()->addPaymentPackage($package);

        do_action(tdf_prefix().'/paymentPackages/synchronize');

        wp_safe_redirect(admin_url('admin.php?page='.tdf_prefix().'-edit-package&packageId='.$packageId));
        exit;
    }

}