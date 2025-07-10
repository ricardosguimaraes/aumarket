<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Payments\BasePaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpPaymentPackage;
use Tangibledesign\Framework\Models\Payments\BumpUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackage;
use Tangibledesign\Framework\Models\Payments\PaymentPackageInterface;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\UserPaymentPackageInterface;
use Tangibledesign\Framework\Models\User\User;
use WP_User;

class ManageUserPaymentPackagesServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('edit_user_profile', [$this, 'addSection'], 9);
        add_action('show_user_profile', [$this, 'addSection'], 9);

        add_action('admin_menu', [$this, 'addMenuItems']);

        add_action('admin_post_' . tdf_prefix() . '/user-payment-packages/update', [$this, 'update']);
        add_action('admin_post_' . tdf_prefix() . '/user-payment-packages/apply', [$this, 'apply']);
        add_action('admin_post_' . tdf_prefix() . '/user-payment-packages/remove', [$this, 'remove']);
    }

    public function remove(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $userPaymentPackageId = (int)($_POST['id'] ?? '');
        if (empty($userPaymentPackageId)) {
            return;
        }

        $userPaymentPackage = tdf_user_payment_package_factory()->create($userPaymentPackageId);
        if (!$userPaymentPackage instanceof UserPaymentPackageInterface) {
            return;
        }

        $userPaymentPackage->delete();

        $this->successJsonResponse();
    }

    public function apply(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $paymentPackage = tdf_payment_package_factory()->create((int)($_POST['payment_package_id'] ?? 0));
        if (!$paymentPackage instanceof PaymentPackageInterface) {
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die(tdf_admin_string('payment_package_not_found'));
        }

        $user = tdf_user_factory()->create((int)($_POST['user'] ?? 0));
        if (!$user instanceof User) {
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die(tdf_admin_string('user_not_found'));
        }

        $user->addPaymentPackage($paymentPackage);

        wp_redirect(admin_url('user-edit.php?user_id=' . $user->getId()));
        exit;
    }

    public function update(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $userPaymentPackageId = (int)($_POST['id'] ?? 0);
        $userPaymentPackage = tdf_user_payment_package_factory()->create($userPaymentPackageId);
        if (!$userPaymentPackage instanceof UserPaymentPackageInterface) {
            /** @noinspection ForgottenDebugOutputInspection */
            wp_die(tdf_admin_string('user_payment_package_not_found'));
        }

        $userPaymentPackage->setMeta(BasePaymentPackage::CATEGORIES, $_POST['package'][BasePaymentPackage::CATEGORIES] ?? []);

        if ($userPaymentPackage instanceof RegularUserPaymentPackage) {
            $userPaymentPackage->setMeta(PaymentPackage::NUMBER, $_POST['package'][PaymentPackage::NUMBER] ?? 0);
            $userPaymentPackage->setMeta(PaymentPackage::EXPIRE, $_POST['package'][PaymentPackage::EXPIRE] ?? 0);
            $userPaymentPackage->setMeta(PaymentPackage::FEATURED_EXPIRE, $_POST['package'][PaymentPackage::FEATURED_EXPIRE] ?? 0);
            $userPaymentPackage->setMeta(PaymentPackage::BUMPS_NUMBER, $_POST['package'][PaymentPackage::BUMPS_NUMBER] ?? 0);
            $userPaymentPackage->setMeta(PaymentPackage::BUMPS_INTERVAL, $_POST['package'][PaymentPackage::BUMPS_INTERVAL] ?? 0);
        } elseif ($userPaymentPackage instanceof BumpUserPaymentPackage) {
            $userPaymentPackage->setMeta(BumpPaymentPackage::BUMPS_NUMBER, $_POST['package'][BumpPaymentPackage::BUMPS_NUMBER] ?? 0);
        }

        wp_redirect(admin_url('admin.php?page=tdf-user-payment-packages-edit&id=' . $userPaymentPackage->getId()));
        exit;
    }

    public function addMenuItems(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('payment_packages'),
            tdf_admin_string('payment_packages'),
            'manage_options',
            'tdf-user-payment-packages-apply',
            static function () {
                tdf_load_view('user-payment-packages/apply', [
                    'user' => tdf_user_factory()->create((int)($_GET['user'] ?? 0)),
                    'paymentPackages' => tdf_app('payment_packages')->merge(tdf_app('bumps_payment_packages')),
                ]);
            }
        );

        add_submenu_page(
            tdf_prefix() . '_hidden',
            tdf_admin_string('payment_packages'),
            tdf_admin_string('payment_packages'),
            'manage_options',
            'tdf-user-payment-packages-edit',
            static function () {
                $userPaymentPackageId = (int)($_GET['id'] ?? 0);
                $userPaymentPackage = tdf_user_payment_package_factory()->create($userPaymentPackageId);
                if (!$userPaymentPackage instanceof UserPaymentPackageInterface) {
                    /** @noinspection ForgottenDebugOutputInspection */
                    wp_die(tdf_admin_string('user_payment_package_not_found'));
                }

                tdf_load_view('user-payment-packages/edit', [
                    'userPaymentPackage' => $userPaymentPackage
                ]);
            }
        );
    }

    public function addSection(WP_User $user): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        tdf_load_view('user/payment-packages', [
            'user' => tdf_user_factory()->create($user)
        ]);
    }
}